<?php
/**
 * 福袋抽奖
 */
namespace frontend\modules\activity\controllers;

use components\XyXy;
use Yii;
use common\models\redis\LotteryList as Activity;
use common\models\redis\LotteryWinner as Winner;
use common\models\redis\LotteryLog as Log;
use common\models\redis\LotteryPrize as Prize;
use common\models\redis\LotteryPraise as Praise;
use yii\base\ErrorException as Exception;
use yii\web\NotFoundHttpException;

class LuckyController extends \frontend\modules\activity\components\Controller
{

    public $enableCsrfValidation = false;

    public $layout = false;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $currentaction = $action->id;
        $novalidactions = ['lottery'];
        if(in_array($currentaction,$novalidactions))
        {
            $action->controller->enableCsrfValidation = true;
        }
        parent::beforeAction($action);
        return true;
    }

    /**
     * @Desc: 抽奖数据初始化
     * @User: zhujw <zhjw@xxcb.cn>
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        //判断是否在微信内
        if (!$this->_isWechat())
        {
            $this->_errorShow('请在微信内打开链接！');
        }

        //判断是否有传参
        $guid = Yii::$app->request->get('guid');
        if (!$guid)
        {
            throw new NotFoundHttpException;
        }

        //从redis数据库中获取数据信息，redis不支持 > < 操作
        $now = time();
        $model = new Activity();
        $lottery = $model->find()
                ->where(['group_id' => $guid])
                ->andWhere(['between', 'start_time', 0, $now])
                ->andWhere(['between', 'end_time', $now, $now+86400000])
                ->asArray()
                ->one();

        if (!$lottery)
        {
            return $this->render('error', ['message' => '活动还未开启，不要心急噢~']);
        }

        //全局规则过滤
        if ($lottery['global_rule'])
        {
            $globalRules = \common\models\redis\LotteryRules::find()->asArray()->one();

            if ($globalRules)
            {
                //主动拒绝
                if ($globalRules['refuse'] > 0)
                {
                    if (mt_rand(1, 100) <= $globalRules['refuse'])
                    {
                        throw new NotFoundHttpException;
                    }
                }

                //黑名单
                if ($globalRules['black'])
                {
                    $blackList = explode("\r\n", $globalRules['black']);
                    foreach ($blackList as $black)
                    {
                        if (XyXy::ipInNetwork(XyXy::getIp(), $black))
                        {
                            throw new NotFoundHttpException;
                        }
                    }
                }
            }
        }

        //针对活动的主动拒绝
        if ($lottery['refuse'] > 0)
        {
            if (mt_rand(1, 100) <= $lottery['refuse'])
            {
                throw new NotFoundHttpException;
            }
        }

        //针对活动的黑名单
        if ($lottery['black'])
        {
            $blackList = explode("\r\n", $lottery['black']);
            foreach ($blackList as $black)
            {
                if (XyXy::ipInNetwork(XyXy::getIp(), $black))
                {
                    throw new NotFoundHttpException;
                }
            }
        }

        //微信用户授权登录
        $appName = 'xxcb';
        $open_id = Yii::$app->request->cookies->getValue('wxs_openId_' . $appName);
        $snsApi = $lottery['silence'] ? 'snsapi_base' : 'snsapi_userinfo';

        if (!$open_id)
        {
            $returnUrl = Yii::$app->request->getAbsoluteUrl();
            Yii::$app->response
                    ->redirect(\components\XyXy::getFrontendWebUrl() . '/wechat/oauth/callback.html?appName='.$appName.'&snsApi='.$snsApi.'&returnUrl=' . urlencode($returnUrl))
                    ->send();
            exit;
        }

        //用户活动记录初始化
        $redisKeyPre = $this->redisKeyPre($open_id, $lottery['id']);
        $redis = Yii::$app->redis;
        if ($redis->get(md5($redisKeyPre . 'times')) === null)
        {
            $redis->set(md5($redisKeyPre . 'times'), 0);
            $redis->set(md5($redisKeyPre . 'share'), 0);
            $redis->set(md5($redisKeyPre . 'praise'), 0);
        }

        //获取点赞总数
        $praiseTotal = $this->totalPraise($guid);
        $userInfo = Yii::$app->request->cookies->getValue('wxs_userInfo_xxcb');
        if ($userInfo)
        {
            $userInfo = \GuzzleHttp\json_decode($userInfo, true);
        }

        //校验活动状态
        $lottery_status = $this->_checkLottery($lottery);
        if ($lottery_status < 0)
        {
            /**
             * -1：未开启  -2：已结束 -3：活动已关闭
             */
            return $this->renderPartial('index', [
                'status' => $lottery_status,
                'praise' => $praiseTotal,
                'guid' => $guid,
                'nickname' => $userInfo['nickname']
            ]);
        }

        //校验用户状态
        $user_status = $this->_checkUserStatus($open_id, $lottery);
        if ($user_status < 0)
        {
            /**
             * -4：已中奖  -5：请完善资料 -6：分享之后可增加抽奖次数 -7：抽奖次数已用完 -8：点赞之后才能抽奖
             */
            $bonus_amount = 0;
            if ($user_status == -4)
            {
                $bonus_amount = Yii::$app->redis->get(md5($redisKeyPre . 'winner'));
            }
            return $this->renderPartial('index', [
                    'status' => $user_status,
                    'praise' => $praiseTotal,
                    'guid' => $guid,
                    'bonus_amount' => $bonus_amount,
                    'nickname' => $userInfo['nickname']
            ]);
        }

        return $this->renderPartial('index', [
            'status' => 0,
            'praise' => $praiseTotal,
            'guid' => $guid,
            'nickname' => $userInfo['nickname']
        ]);
    }

    /**
     * @Desc: 返回redis统一前缀
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $open_id
     * @param $id
     * @return string
     */
    protected function redisKeyPre($open_id, $id)
    {
        return $open_id .'_'. $id . '_';
    }

    /**
     * @Desc: 抽奖操作
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionLottery()
    {
        try
        {
            if (!$this->_isWechat())
            {
                throw new Exception(-12, -1);
            }

            //ajax来源判断
            $refer = $_SERVER['HTTP_REFERER'];
            if (strpos($refer, XyXy::getFrontendWebUrl()) === false)
            {
                throw new Exception(-12, -1);
            }

            //判断是否有传参
            $guid = Yii::$app->request->post('guid');
            if (!$guid)
            {
                throw new Exception(-12, -1);
            }

            //从redis数据库中获取数据信息，redis不支持 > < 操作
            $now = time();
            $model = new Activity();
            $lottery = $model->find()
                    ->where(['group_id' => $guid])
                    ->andWhere(['between', 'start_time', 0, $now])
                    ->andWhere(['between', 'end_time', $now, $now+86400000])
                    ->asArray()
                    ->one();

            if (!$lottery)
            {
                throw new Exception(-12, -1);
            }

            //获取用户信息
            $appName = $lottery['mp_type'] == 2 ? 'xxcb' : '';
            $open_id = Yii::$app->request->cookies->getValue('wxs_openId_' . $appName);
            if (!$open_id)
            {
                throw new Exception(-12, -1);
            }

            //全局规则过滤
            if ($lottery['global_rule'])
            {
                $globalRules = \common\models\redis\LotteryRules::find()->asArray()->one();
                if ($globalRules)
                {
                    //主动拒绝
                    if ($globalRules['refuse'] > 0)
                    {
                        if (mt_rand(1, 100) <= $globalRules['refuse'])
                        {
                            throw new Exception(-12, -1);
                        }
                    }

                    //黑名单
                    if ($globalRules['black'])
                    {
                        $blackList = explode("\r\n", $globalRules['black']);
                        foreach ($blackList as $black)
                        {
                            if (XyXy::ipInNetwork(XyXy::getIp(), $black))
                            {
                                throw new Exception(-12, -1);
                            }
                        }
                    }

                    $whiteArr = [];
                    if ($globalRules['white'])
                    {
                        $whiteList = explode("\r\n", $globalRules['white']);
                        foreach ($whiteList as $white)
                        {
                            $whiteUser = explode('###', $white);
                            $whiteArr[] = $whiteUser[0];
                        }
                    }

                    //地区限制 刘程  oAHdHr5h1L57aYrS3ohompNujStg 翠花  oAHdHr9FrML7QdDims8GXl_8qWko
                    if (!in_array($open_id, $whiteArr))
                    {
                        if ($globalRules['region'])
                        {
                            $ipregion = new \components\helper\Ip2region(\components\XyXy::getIpdb());
                            $region = $ipregion->btreeSearch(XyXy::getIp())['region'];
                            if (strpos($region, $globalRules['region']) === false)
                            {
                                throw new Exception(-11, -1);
                            }
                        }
                    }
                }
            }

            //针对活动的主动拒绝
            if ($lottery['refuse'] > 0)
            {
                if (mt_rand(1, 100) <= $lottery['refuse'])
                {
                    throw new Exception(-12, -1);
                }
            }

            //针对活动的黑名单
            if ($lottery['black'])
            {
                $blackList = explode("\r\n", $lottery['black']);
                foreach ($blackList as $black)
                {
                    if (XyXy::ipInNetwork(XyXy::getIp(), $black))
                    {
                        throw new Exception(-12, -1);
                    }
                }
            }

            //地区限制
            if ($lottery['region'])
            {
                if (!isset($ipregion))
                    $ipregion = new \components\helper\Ip2region(\components\XyXy::getIpdb());
                $region = $ipregion->btreeSearch(XyXy::getIp())['region'];
                if (strpos($region, $lottery['region']) === false)
                {
                    throw new Exception(-11, 1);
                }
            }

            //校验活动
            $lottery_status = $this->_checkLottery($lottery);
            if ($lottery_status < 0) throw new Exception($lottery_status, -2);

            //校验用户状态
            $user_status = $this->_checkUserStatus($open_id, $lottery);
            if ($user_status < 0) throw new Exception($user_status, -2);

            //校验用户活动记录是否存在
            $redisKeyPre = $this->redisKeyPre($open_id, $lottery['id']);
            $redis = Yii::$app->redis;
            if ($redis->get(md5($redisKeyPre . 'times')) === null)
            {
                throw new Exception(-12, -1);
            }

            //抽奖操作
            $prizeDetail = [];
            if ($lottery['bonus'] && $lottery['bonus_random'])
            {
                $surplus = $lottery['bonus_amount'] - $lottery['bonus_amount_use'];   //剩余金额
                if ($surplus < $lottery['min_amount'])
                    throw new Exception(-9, -2);   //红包已抢光
                $win_ret = 0;
                if (mt_rand(1, 10000) <= $lottery['probability'])
                {
                    $win_ret = mt_rand($lottery['min_amount'],
                            ($surplus > $lottery['max_amount'] ? $lottery['max_amount'] : $surplus));
                }

            }
            else
            {
                $prize = Prize::find()->where(['act_id' => $lottery['id']])->asArray()->all();
                if (!$prize) throw new Exception(-12, -1);

                $win_param = [];
                $probability = 0;
                foreach ($prize as $p)
                {
                    $win_param[$p['id']] = $p['probability'];
                    $probability += $p['probability'];
                    $prizeDetail[$p['id']] = $p;
                }

                //抽奖
                $win_param[0] = 10000 - $probability;
                $win_ret = $this->_getWinner($win_param);
            }

            $log['times'] = $redis->get(md5($redisKeyPre . 'times'));
            $log['share'] = $redis->get(md5($redisKeyPre . 'share'));
            $log['praise'] = $redis->get(md5($redisKeyPre . 'praise'));
            //抽奖次数+1
            $totalTimes = ($lottery['share'] && $log['share']) ? ($lottery['draw_num'] + $lottery['share_add_num']) : $lottery['draw_num'];
            if ($log['times'] >= $totalTimes)
            {
                throw new Exception(-7, -2);   //次数已经用完
            }

            //次数+1，并且判断原子操作之后的值是否符合要求
            if ($redis->incr(md5($redisKeyPre . 'times')) > $totalTimes)
            {
                throw new Exception(-7, -2);   //次数已经用完
            }

            $errCode = $log['share'] ? -7 : -6;

            //记录中奖记录
            if($win_ret > 0)
            {
                $bonus_amount = 0;
                if ($lottery['bonus'] && $lottery['bonus_random'])
                {
                    $bonus_amount = $win_ret;
                }
                elseif ($lottery['bonus'])
                {
                    if ($prizeDetail[$win_ret]['bonus_random']) #随机红包
                    {
                        $surplus = $prizeDetail[$win_ret]['bonus_amount'] - $prizeDetail[$win_ret]['bonus_amount_use'];
                        if ($surplus < $prizeDetail[$win_ret]['min_amount'])
                            throw new Exception($errCode, -2);   //没有中奖，再接再厉

                        $bonus_amount = mt_rand($prizeDetail[$win_ret]['min_amount'],
                                ($surplus > $prizeDetail[$win_ret]['max_amount'] ? $prizeDetail[$win_ret]['max_amount'] : $surplus));
                        if ($bonus_amount <= 0) throw new Exception($errCode, -2);   //没有中奖，再接再厉
                        if ($redis->incrby('prize_init_' . $win_ret, $bonus_amount) > $prizeDetail[$win_ret]['bonus_amount'])
                        {
                            throw new Exception($errCode, -2);
                        }
                        $prizeMod = Prize::find()
                                ->where(['id' => $prizeDetail[$win_ret]['id']])
                                ->one();
                        if ($prizeMod['bonus_amount'] < $prizeMod['bonus_amount_use'] + $bonus_amount)
                        {
                            throw new Exception($errCode, -2);   //没有中奖，再接再厉
                        }
                        $prizeMod->bonus_amount_use = $prizeMod->bonus_amount_use + $bonus_amount;
                        $prizeMod->save();
                    }
                    else
                    {
                        $bonus_amount = $prizeDetail[$win_ret]['bonus_amount'];
                        $prizeMod = Prize::find()
                                ->where(['id' => $win_ret])
                                ->one();
                        if ($redis->incr('prize_init_' . $win_ret) > $prizeMod['num'])
                        {
                            throw new Exception($errCode, -2);
                        }
                        if ($prizeMod['num'] < $prizeMod['num_use'] + 1)
                        {
                            throw new Exception($errCode, -2);   //没有中奖，再接再厉
                        }
                        $prizeMod->num_use = $prizeMod->num_use + 1;
                        $prizeMod->save();
                    }
                }
                else
                {
                    $prizeMod = Prize::find()
                            ->where(['id' => $win_ret])
                            ->one();
                    if ($prizeMod['num'] < $prizeMod['num_use'] + 1)
                    {
                        throw new Exception($errCode, -2);   //没有中奖，再接再厉
                    }
                    $prizeMod->num_use = $prizeMod->num_use + 1;
                    $prizeMod->save();
                }

                //增加已使用金额
                if ($bonus_amount > 0 && $lottery['bonus_random'])
                {
                    $actMod = Activity::find()
                            ->where(['id' => $lottery['id']])
                            ->one();
                    if ($actMod['bonus_amount'] < $actMod['bonus_amount_use'] + $bonus_amount)
                    {
                        throw new Exception($errCode, -2);   //没有中奖，再接再厉
                    }
                }

                $userInfo = Yii::$app->request->cookies->getValue('wxs_userInfo_xxcb');
                if ($userInfo)
                {
                    $userInfo = \GuzzleHttp\json_decode($userInfo, true);
                }

                $winnerModel = new Winner();
                $winnerModel->act_id = $lottery['id'];
                $winnerModel->open_id = $open_id;
                $winnerModel->header = $userInfo ? $userInfo['original']['headimgurl'] : '';
                $winnerModel->nickname = $userInfo ? $userInfo['nickname'] : '';
                $winnerModel->prize_id = $win_ret;
                $winnerModel->bonus_amount = $bonus_amount;
                $winnerModel->group_id = $guid;
                $winnerModel->insert_time = time();
                $winnerModel->complete = 0;
                $winnerModel->share = 0;
                $winnerModel->get_time = 0;
                $winnerModel->is_fail = 0;
                $bonus_amount > 0 && $winnerModel->billno = $this->_getBillNo($lottery['id']);

                //原子操作已中奖次数
                $winnerTimesKey = md5($this->redisKeyPre($open_id, $lottery['id']) . 'winner_times');
                if (Yii::$app->redis->incr($winnerTimesKey) > 1)
                {
                    throw new Exception(-4, -2);   //已中奖
                }

                if ($winnerModel->save())
                {
                    $key = md5($this->redisKeyPre($open_id, $lottery['id']) . 'winner');
                    Yii::$app->redis->set($key, $bonus_amount);
                    $this->success('中奖了', [
                            'prize_id' => $win_ret,
                            'prize_name' => $lottery['bonus'] && $lottery['bonus_random'] ? '' : $prizeDetail[$win_ret]['name'],
                            'bonus_amount' => $bonus_amount/100,
                            'nickname' => $userInfo['nickname']
                    ]);
                }
                //保存失败，将中奖次数-1
                else
                {
                    Yii::$app->redis->decr($winnerTimesKey);
                }
            }

            throw new Exception($errCode, -2);   //没有中奖，再接再厉
        }
        catch (Exception $e)
        {
            $this->error('没有中奖', $e->getMessage());
        }
    }

    /**
     * @Desc: 点赞操作
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionPraise()
    {
        try
        {
            if (!$this->_isWechat())
            {
                throw new Exception('请在微信内打开页面', -1);
            }

            //ajax来源判断
            $refer = $_SERVER['HTTP_REFERER'];
            if (strpos($refer, XyXy::getFrontendWebUrl()) === false)
            {
                throw new Exception('非法请求', -1);
            }

            //判断是否有传参
            $guid = Yii::$app->request->post('guid');
            if (!$guid)
            {
                throw new Exception('参数错误', -1);
            }

            //从redis数据库中获取数据信息，redis不支持 > < 操作
            $now = time();
            $model = new Activity();
            $lottery = $model->find()
                    ->where(['group_id' => $guid])
                    ->andWhere(['between', 'start_time', 0, $now])
                    ->andWhere(['between', 'end_time', $now, $now+86400000])
                    ->asArray()
                    ->one();

            if (!$lottery)
            {
                throw new Exception('活动不存在', -1);
            }

            $appName = $lottery['mp_type'] == 2 ? 'xxcb' : '';
            $open_id = Yii::$app->request->cookies->getValue('wxs_openId_' . $appName);
            if (!$open_id)
            {
                throw new Exception('非法请求，拒绝访问', -1);
            }

            //点赞次数+1
            $redisKeyPre = $this->redisKeyPre($open_id, $lottery['id']);
            $redis = Yii::$app->redis;
            $redis->incr(md5($redisKeyPre . 'praise'));

            $init = $this->totalPraise($guid, true);
            $this->success('点赞成功', $init);
        }
        catch (\yii\base\Exception $e)
        {
            $this->error($e->getMessage());
        }
    }

    /**
     * @Desc: 获取点赞总数
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $guid
     * @param bool|false $inc
     * @return array|int|null|\yii\redis\ActiveRecord
     */
    protected function totalPraise($guid, $inc = false)
    {
        $guid = '3795E0E7-A75D-1F18-A4AF-9D676DDD0B66';
        $redis = Yii::$app->redis;
        $key = md5($guid . '_total_praise');
        $total = $redis->get($key);

        if ($total === null)
        {
            $total = Praise::find()->where(['act_id' => $guid])->one();
            $total = $total ? ($total['praise'] + 15692) : 15692;
            $redis->set($key, $total);
        }

        if ($inc)
        {
            $total = $redis->incr($key);
        }
        return $total;
    }

    /**
     * @Desc: PC端点赞
     * @User: zhujw <zhjw@xxcb.cn>
     * @throws Exception
     */
    public function actionPcPraise()
    {
        try
        {
            $guid = Yii::$app->request->get('guid');
            $type = Yii::$app->request->get('type');

            if (!$guid) throw new NotFoundHttpException;

            //获取总数
            if ($type == 'total')
            {
                $this->_successReturn($this->totalPraise($guid));
            }

            $this->_successReturn($this->totalPraise($guid, true));
        }
        catch(\yii\base\Exception $e)
        {
            $this->_failReturn($e->getMessage());
        }

    }

    /**
     * @Desc: 用户行为时长判断
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionBehavior()
    {
        $this->success('成功！');
    }

    public function actionShare()
    {
        try
        {
            //判断是否有传参
            $guid = Yii::$app->request->post('guid');
            if (!$guid)
            {
                throw new \yii\base\Exception('非法请求，拒绝访问！');
            }

            //从redis数据库中获取数据信息，redis不支持 > < 操作
            $now = time();
            $model = new Activity();
            $lottery = $model->find()
                    ->where(['group_id' => $guid])
                    ->andWhere(['between', 'start_time', 0, $now])
                    ->andWhere(['between', 'end_time', $now, $now+86400000])
                    ->asArray()
                    ->one();

            if (!$lottery)
            {
                throw new \yii\base\Exception('非法请求，拒绝访问！');
            }

            $open_id = Yii::$app->request->cookies->getValue('wxs_openId_xxcb');
            if (!$open_id)
            {
                throw new \yii\base\Exception('非法请求，拒绝访问！');
            }

            $key = md5($this->redisKeyPre($open_id, $lottery['id']) . 'share');

            if (Yii::$app->redis->get($key) === false)
            {
                throw new \yii\base\Exception('非法请求，拒绝访问！');
            }

            Yii::$app->redis->incr($key);
            $this->success('分享成功！');
        }
        catch (\yii\base\Exception $e)
        {
            $this->error($e->getMessage());
        }
    }

    /**
     * @Desc: 获取大奖列表
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionList()
    {
        //$guid = Yii::$app->request->post('guid');
        $guid = '3795E0E7-A75D-1F18-A4AF-9D676DDD0B66';
        $list = Yii::$app->redis->get('bigPrizeList' . $guid);
        $list = $list ? \GuzzleHttp\json_decode($list, true) : [];
        $this->success('获取成功', $list);
    }

    /**
     * @Desc: 校验活动状态
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $lottery
     * @return int|string
     */
    private function _checkLottery($lottery)
    {
        //判断时间，如果未设置时间则一直持续
        $now = time();
        if ($lottery['start_time'])
        {
            if ($lottery['start_time'] > $now)
                return -1;//'活动未开启，不要心急噢 :)';
        }

        if ($lottery['end_time'])
        {
            if ($lottery['end_time'] < $now)
                return -2;//'您来晚了，活动已经结束啦 :(';
        }

        //判断活动状态
        if($lottery['status'] == 0)
            return -1; //'活动未开启，不要心急噢 :)';

        if($lottery['status'] == 2)
            return -2; //'您来晚了，活动已经结束啦 :(';

        if($lottery['status'] == 3)
            return -3; //'活动已关闭，感谢您的关注';

        return 1;
    }

    /**
     * @Desc: 校验用户是否分享
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $guid
     * @param $user
     * @param $lottery
     * @return int
     */
    private function _checkUserShare($open_id, $lottery)
    {
        if (!$lottery['share']) return 0;
        $log = Log::find()->where(['act_id' => $lottery['id'], 'open_id' => $open_id])->asArray()->one();
        if ($log && $log['share']) return 1;
        return 0;
    }

    /**
     * @Desc: 校验用户活动状态
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $guid
     * @param $user
     * @param $lottery
     * @return int
     */
    private function _checkUserStatus($open_id, $lottery)
    {
        //判断用户是否已中奖或者是否已经填写完资料
        $winner = Yii::$app->redis->get(md5($open_id . '_' . $lottery['id'] . '_winner'));
        //-1：已中奖，不能再抽奖 -2：已中奖，请完善资料
        if ($winner > 0)
        {
            return -4;
        }

        //判断是否还有抽奖次数
        $redisKeyPre = $this->redisKeyPre($open_id, $lottery['id']);
        $redis = Yii::$app->redis;
        $log['times'] = $redis->get(md5($redisKeyPre . 'times'));
        $log['praise'] = $redis->get(md5($redisKeyPre . 'praise'));
        $log['share'] = $redis->get(md5($redisKeyPre . 'share'));
        if ($log)
        {
            if ($log['times'] < $lottery['draw_num']) return $lottery['draw_num'] - $log['times'];  //返回剩余次数
            if ($log['times'] == $lottery['draw_num'] && !$lottery['share']) return -7;             //剩余次数为0
            if ($log['praise'] < 1) return -8;  //请先点赞
            if (!$log['share'] && $lottery['share'] && $lottery['share_add_num'])
            {
                //分享后可增加抽奖次数d
                return -6;
            }
            else
            {
                //分享后剩余次数
                $last = $lottery['draw_num'] + $lottery['share_add_num'] - $log['times'];
            }
        }
        else
        {
            $last = $lottery['draw_num'];
        }
        if ($last == 0) return -7;
        return $last;
    }

    /**
     * 根据设置的几率计算出符合条件的奖项id
     * array(
     *  'id' => 概率
     * )
     */
    private function _getWinner($proArr)
    {
        $result = 0;
        $pro = 0;
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //获取随机数
        asort($proArr);
        $randNum = mt_rand(1, $proSum);
        //概率数组循环
        foreach ($proArr as $key => $proCur)
        {
            if($randNum <= $proCur)
            {
                $result = $key;
                $pro = $proCur;
                break;
            }
            $randNum -= $proCur;
        }
        unset($proArr);
        //$log = '随机数：' . $initRnd . ' ==== 奖等：' . $result . ' ==== 概率：' . $pro . ' ==== 时间：' . date('Y-m-d H:i:s') .  "\r\n";
        //\components\XyXy::log($log, 'lottery_result_test');
        return $result;
    }

    private function _getBillNo($lot_id)
    {
        $bill_no = 1243685502;
        $bill_no .= date('mdHis');
        $bill_no .= mt_rand(10, 99);
        $bill_no .= str_pad($lot_id, 6, '0', STR_PAD_LEFT);
        return $bill_no;
    }

    private function _createGuid()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12);
        return $uuid;
    }

}
