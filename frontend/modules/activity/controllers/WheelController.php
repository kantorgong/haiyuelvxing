<?php
/**
 * @desc 大转盘抽奖
 * @date 217-4-17
 * @author zhujw
 */
namespace frontend\modules\activity\controllers;

use common\models\wxservice\LotteryList;
use common\models\wxservice\LotteryPrize;
use common\models\wxservice\LotteryWinner;
use components\helper\CommonUtility;
use Yii;

class WheelController extends \frontend\modules\activity\components\Controller
{

    public $enableCsrfValidation = false;

    public $layout = false;

    private $_lotteryStatus = [
        -1 => '活动还未开启，不要心急噢',
        -2 => '活动已结束，你来晚啦',
        -3 => '活动已关闭，感谢你的关注'
    ];

    public function init()
    {
        header('Access-Control-Allow-Origin: http://localhost:8080');
        $this->_error_log_key = Yii::$app->redis->hget('error_log_redis_key', 'frontend-wheel');
        parent::init();
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
            $this->error(-1, '请在微信内访问本链接');
        }

        //判断是否有传参
        $guid = Yii::$app->request->get('guid');
        if (!$guid)
        {
            $this->error(-1, '活动不存在');
        }

        //获取当前开启的活动
        $now = time();
        $lottery = [];
        $redis = Yii::$app->redis;
        $actId = $redis->get('lottery_active:' . $guid);
        if (!$actId)
        {
            $lotteryList = $redis->hvals('lottery_group:' . $guid);
            foreach ($lotteryList as $lot)
            {
                $lotTmp = \GuzzleHttp\json_decode($lot, true);
                if ($lotTmp['start_time'] < $now && $lotTmp['end_time'] >= $now && (in_array($lotTmp['status'], [0, 1])))
                {
                    if (!$lottery)
                    {
                        $lottery = $lotTmp;
                        continue;
                    }

                    //越早添加的优先生效
                    if ($lottery && $lottery['id'] > $lotTmp['id'])
                    {
                        $lottery = $lotTmp;
                    }
                }
            }

            if ($lottery)
            {
                $redis->set('lottery_active:' . $guid, $lottery['id']);
                $redis->expire('lottery_active:' . $guid, $lottery['end_time'] - $now);
            }
        }
        else
        {
            $lottery = $redis->hget('lottery_group:' . $guid, 'lottery_list:' . $actId);
            $lottery = \GuzzleHttp\json_decode($lottery, true);
        }

        if (!$lottery)
        {
            $this->error(-1, '活动未开启或者已结束');
        }

        //设置活动session状态
        Yii::$app->session->set('lottery_group', $guid);
        Yii::$app->session->set('lottery_active', $lottery['id']);

        $remain = $this->_checkStatus($lottery);

        $userInfo = Yii::$app->wechat->user;

        $this->success([
                'status' => 0,
                'nickname' => $userInfo->nickname,
                'lottery' => $this->_lotteryRt($lottery),
                'prize' => $this->_prizeRt($lottery),
                'times' => $remain,
                'bonus_amount' => 0,
                'prize_name' => ''
        ]);
    }

    private function _lotteryRt($lottery)
    {
        return \GuzzleHttp\json_encode([
                'bonus' => $lottery['bonus'],
                'share' => $lottery['share'],
                'act_note' => $lottery['act_note'],
                'act_name' => $lottery['act_name']
        ]);
    }

    private function _prizeRt($lottery)
    {
        //奖品格式化
        $prizeRt = [];
        $prize = Yii::$app->redis->hvals('lottery_list:' . $lottery['id']);
        if ($prize)
        {
            foreach ($prize as $p)
            {
                $p = \GuzzleHttp\json_decode($p, true);
                $prizeRt[$p['id']] = [
                        'name' => $p['name'],
                        'content' => $p['content'],
                        'num' => $p['num_show'] ?: $p['num']
                ];
            }
        }

        ksort($prizeRt);
        $prizeRt = array_values($prizeRt);
        return \GuzzleHttp\json_encode($prizeRt, true);
    }

    private function _checkStatus($lottery)
    {
        $redis = Yii::$app->redis;

        //全局规则过滤
        if ($lottery['global_rule'])
        {
            $globalRules = $redis->get('lottery_rules:global');

            if ($globalRules)
            {
                //主动拒绝
                if ($globalRules['refuse'] > 0)
                {
                    if (mt_rand(1, 100) <= $globalRules['refuse'])
                    {
                        $this->error(-1, '活动太火爆，请稍候重试~');
                    }
                }

                //黑名单
                if ($globalRules['black'])
                {
                    $blackList = explode("\r\n", $globalRules['black']);
                    foreach ($blackList as $black)
                    {
                        if (CommonUtility::ipInNetwork(CommonUtility::getIp(), $black))
                        {
                            $this->error(-1, '活动太火爆，请稍候重试~');
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
                $this->error(-1, '活动太火爆，请稍候重试~');
            }
        }

        //针对活动的黑名单
        if ($lottery['black'])
        {
            $blackList = explode("\r\n", $lottery['black']);
            foreach ($blackList as $black)
            {
                if (CommonUtility::ipInNetwork(CommonUtility::getIp(), $black))
                {
                    $this->error(-1, '活动太火爆，请稍候重试~');
                }
            }
        }

        //微信用户授权登录
        $this->oauthCheck([
                'app_alias_name' => $lottery['mp_type'],
                'silence' => $lottery['silence'],
                'ajax' => true
        ]);

        $userInfo = Yii::$app->wechat->user;

        //用户活动记录初始化
        $redisKey = 'user:' . $lottery['id'] . ':' . $userInfo->id;
        if (!$redis->hgetall($redisKey) && $userInfo->id)
        {
            //初始化抽奖次数，分享次数，中奖次数，奖品ID或者奖品金额，是否完善资料
            $redis->hmset($redisKey, 'times', 0, 'share', 0, 'win', 0, 'prize', 0, 'complete', 0);
            $redis->incr('lottery_statistics:user:' . $lottery['id']);  //统计数据，该活动的参与人数
        }

        //地区限制
        if ($lottery['region'])
        {
            if (!isset($ipregion))
                $ipregion = new \components\helper\Ip2region(CommonUtility::getIpdb());
            $region = $ipregion->btreeSearch(CommonUtility::getIp())['region'];
            if (strpos($region, $lottery['region']) === false)
            {
                $this->error(-1, '本活动仅限湖南地区参与');
            }
        }

        //校验活动状态
        $lottery_status = $this->_checkLottery($lottery);
        if ($lottery_status < 0)
        {
            $this->error(-1, $this->_lotteryStatus[$lottery_status]);
        }

        //校验用户状态
        $user_status = $this->_checkUserStatus($lottery, $redisKey);
        if ($user_status < 0)
        {
            /**
             * -4：已中奖  -5：请完善资料 -6：分享之后可增加抽奖次数 -7：抽奖次数已用完
             */
            $bonus_amount = 0;
            $prize_name = '';
            if ($user_status == -4)
            {
                $bonus_amount = $redis->hget($redisKey, 'prize');
                if (!$lottery['bonus'])
                {
                    //未完善资料
                    if (!$redis->hget($redisKey, 'complete'))
                    {
                        $user_status = -5;
                    }
                    $prize = $redis->hget('lottery_list:' . $lottery['id'], 'lottery_prize:' . $bonus_amount);
                    $prize = \GuzzleHttp\json_decode($prize, true);
                    $prize_name = $prize['name'];
                    $bonus_amount = 0;
                }
            }

            $this->success([
                'status' => $user_status,
                'bonus_amount' => $bonus_amount ? $bonus_amount/100 : 0,
                'nickname' => $userInfo->nickname,
                'lottery' => $this->_lotteryRt($lottery),
                'prize' => $this->_prizeRt($lottery),
                'times' => 0,
                'prize_name' => $prize_name
            ]);
        }
        else
        {
            return $user_status;  //返回剩余次数
        }
    }

    /**
     * @Desc: 抽奖操作
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionLottery()
    {

        if (!$this->_isWechat())
        {
            $this->error(-1, '活动太火爆，请稍候再试');
        }

        //ajax来源判断
//        $refer = $_SERVER['HTTP_REFERER'];
//        if (strpos($refer, XyXy::getFrontendWebUrl()) === false)
//        {
//            $this->error(-12, '网络忙');
//        }

        //获取当前活动组和活动ID
        $lotteryGroup = Yii::$app->session->get('lottery_group');
        $lotteryId = Yii::$app->session->get('lottery_active');

        if (!$lotteryId || !$lotteryGroup)
        {
            $this->error(-1, '活动太火爆，请稍候再试');
        }

        $redis = Yii::$app->redis;
        $lottery = $redis->hget('lottery_group:' . $lotteryGroup, 'lottery_list:' . $lotteryId);
        if (!$lottery)
        {
            $this->error(-1, '活动太火爆，请稍候再试');
        }

        $lottery = \GuzzleHttp\json_decode($lottery, true);
        $this->_checkStatus($lottery);
        $userInfo = Yii::$app->wechat->user;

        //抽奖操作
        $prizeDetail = [];
        if ($lottery['bonus'] && $lottery['bonus_random'])
        {
            $surplus = $lottery['bonus_amount'] - $redis->get('lottery_use:' . $lottery['id']);   //剩余金额
            if ($surplus < $lottery['min_amount'])
            {
                $this->error(-1, '你来晚啦，红包已抢光啦');
            }
            $win_ret = 0;
            if (mt_rand(1, 10000) <= $lottery['probability'])
            {
                $win_ret = mt_rand($lottery['min_amount'],
                        ($surplus > $lottery['max_amount'] ? $lottery['max_amount'] : $surplus));
            }
        }
        else
        {
            $prize = $redis->hvals('lottery_list:' . $lottery['id']);
            if (!$prize)
            {
                $this->error(-1, '活动太火爆，请稍候再试');
            }

            $win_param = [];
            $probability = 0;
            foreach ($prize as $p)
            {
                $p = \GuzzleHttp\json_decode($p, true);
                $win_param[$p['id']] = $p['probability'];
                $probability += $p['probability'];
                $prizeDetail[$p['id']] = $p;
            }

            //抽奖
            $win_param[0] = 10000 - $probability;
            $win_ret = $this->_getWinner($win_param);
        }

        $redisKey = 'user:' . $lottery['id'] . ':' . $userInfo->id;

        $log['times'] = $redis->hget($redisKey, 'times');
        $log['share'] = $redis->hget($redisKey, 'share');

        $errCode = !$lottery['share'] ? -7 : ($log['share'] ? -7 : -6);
        $wheel = 1;  //是否执行抽奖操作

        //抽奖次数+1
        $totalTimes = ($lottery['share'] && $log['share']) ? ($lottery['draw_num'] + $lottery['share_add_num']) : $lottery['draw_num'];
        if ($log['times'] >= $totalTimes)
        {
            $wheel = 0;
            $this->success(['status' => $errCode, 'wheel' => $wheel]);
        }

        //次数+1，并且判断原子操作之后的值是否符合要求
        $remain = $totalTimes - $redis->hincrby($redisKey, 'times', 1);
        if ($remain < 0)
        {
            $wheel = 0;
            $this->success(['status' => $errCode, 'wheel' => $wheel]);
        }
        elseif ($remain > 0)
        {
            $errCode = -8;   //还有剩余次数可抽奖，请再接再厉
        }

        //统计数据，该活动总抽奖次数
        $redis->incr('lottery_statistics:times:' . $lottery['id']);

        //如果是红包抽奖，并且用户在微信红包发送的黑名单中，则直接未中奖
        if ($lottery['bonus'] && $redis->sismember('lottery_redpack_black', $userInfo->id))
        {
            $win_ret = 0;
        }

        //记录中奖记录
        if($win_ret > 0)
        {
            $bonus_amount = 0;
            if ($lottery['bonus'] && $lottery['bonus_random'])
            {
                if ($redis->incrby('lottery_list_use:' . $lottery['id'], $win_ret) > $lottery['bonus_amount'])
                {
                    $this->success(['status' => $errCode, 'wheel' => $wheel]);
                }
                $bonus_amount = $win_ret;
            }
            elseif ($lottery['bonus'])
            {
                if ($prizeDetail[$win_ret]['bonus_random']) #随机红包
                {
                    $surplus = $prizeDetail[$win_ret]['bonus_amount'] - $redis->get('lottery_prize_use:' . $win_ret);
                    if ($surplus < $prizeDetail[$win_ret]['min_amount'])
                    {
                        $this->success(['status' => $errCode, 'wheel' => $wheel]);
                    }

                    $bonus_amount = mt_rand($prizeDetail[$win_ret]['min_amount'],
                            ($surplus > $prizeDetail[$win_ret]['max_amount'] ? $prizeDetail[$win_ret]['max_amount'] : $surplus));

                    if ($bonus_amount <= 0)
                    {
                        $this->success(['status' => $errCode, 'wheel' => $wheel]);
                    }

                    if ($redis->incrby('lottery_prize_use:' . $win_ret, $bonus_amount) > $prizeDetail[$win_ret]['bonus_amount'])
                    {
                        $this->success(['status' => $errCode, 'wheel' => $wheel]);
                    }
                }
                else
                {
                    $bonus_amount = $prizeDetail[$win_ret]['bonus_amount'];
                    if ($redis->incr('lottery_prize_use:' . $win_ret) > $prizeDetail[$win_ret]['num'])
                    {
                        $this->success(['status' => $errCode, 'wheel' => $wheel]);
                    }
                }
            }
            else
            {
                if ($redis->incr('lottery_prize_use:' . $win_ret) > $prizeDetail[$win_ret]['num'])
                {
                    $this->success(['status' => $errCode, 'wheel' => $wheel]);
                }
            }

            if ($redis->hincrby($redisKey, 'win', 1) > 1)
            {
                $wheel = 0;
                $this->success(['status' => -4, 'wheel' => $wheel]);
            }

            //如果是红包活动，则先写入到redis队列中，然后在发送红包的时候更新到mysql中
            if ($lottery['bonus'])
            {
                $redis->rpush('lottery_bonus_winner_list', \GuzzleHttp\json_encode([
                    'act_id' => $lottery['id'],
                    'mp_type' => $lottery['mp_type'],
                    'open_id' => $userInfo->id,
                    'header' => isset($userInfo->original['headimgurl']) ? $userInfo->original['headimgurl'] : '',
                    'nickname' => isset($userInfo->nickname) ? $userInfo->nickname : '',
                    'prize_id' => $win_ret,
                    'bonus_amount' => $bonus_amount,
                    'group_id' => $lottery['group_id'],
                    'insert_time' => time()
                ]));
            }
            else
            {
                //中奖记录直接写入mysql
                $winnerModel = new \common\models\wxservice\LotteryWinner();
                $winnerModel->act_id = $lottery['id'];
                $winnerModel->mp_type = $lottery['mp_type'];
                $winnerModel->open_id = $userInfo->id;
                $winnerModel->header = isset($userInfo->original['headimgurl']) ? $userInfo->original['headimgurl'] : '';
                $winnerModel->nickname = isset($userInfo->nickname) ? $userInfo->nickname : '';
                $winnerModel->prize_id = $win_ret;
                $winnerModel->bonus_amount = $bonus_amount;
                $winnerModel->group_id = $lottery['group_id'];
                $winnerModel->insert_time = time();
                if (!$winnerModel->save())
                {
                    $redis->hincrby($redisKey, 'win', -1);
                    $this->success(['status' => $errCode, 'wheel' => $wheel]);
                }
            }

            $redis->hset($redisKey, 'prize', ($bonus_amount ? $bonus_amount : $win_ret));

            // 统计数据。奖等中奖数量，奖等已中奖金额
            if (!$lottery['bonus_random'])
            {
                $redis->incr('lottery_statistics:win:' . $win_ret);
                if ($lottery['bonus'])
                {
                    $redis->incrby('lottery_statistics:bonus_amount:' . $win_ret, $bonus_amount);
                }
            }

            $this->success([
                'status' => 0,
                'wheel' => 1,
                'prize_id' => $win_ret,
                'prize_name' => $lottery['bonus'] && $lottery['bonus_random'] ? '' : $prizeDetail[$win_ret]['name'],
                'bonus_amount' => $bonus_amount/100,
                'nickname' => $userInfo->nickname
            ]);
        }

        $this->success(['status' => $errCode, 'wheel' => $wheel]);
    }

    public function actionShare()
    {
        //获取当前活动组和活动ID
        $lotteryGroup = Yii::$app->session->get('lottery_group');
        $lotteryId = Yii::$app->session->get('lottery_active');

        if (!$lotteryId || !$lotteryGroup)
        {
            $this->error(-1, '网络忙，请稍候重试');
        }

        $redis = Yii::$app->redis;
        $lottery = $redis->hget('lottery_group:' . $lotteryGroup, 'lottery_list:' . $lotteryId);

        if (!$lottery)
        {
            $this->error(-12, '网络忙，请稍候重试');
        }

        $lottery = \GuzzleHttp\json_decode($lottery, true);
        //微信用户授权登录
        $this->oauthCheck([
            'app_alias_name' => $lottery['mp_type'],
            'silence' => $lottery['silence'],
            'ajax' => true
        ]);

        $userInfo = Yii::$app->wechat->user;

        //用户活动记录初始化
        $redisKey = 'user:' . $lottery['id'] . ':' . $userInfo->id;

        Yii::$app->redis->hincrby($redisKey, 'share', 1);
        Yii::$app->redis->incr('lottery_statistics:share:' . $lottery['id']);  //统计数据，该活动的分享次数
        $last = $this->_checkUserStatus($lottery, $redisKey);
        $this->success($last);
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
     * @Desc: 校验用户活动状态
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $guid
     * @param $user
     * @param $lottery
     * @return int
     */
    private function _checkUserStatus($lottery, $redisKey)
    {
        $redis = Yii::$app->redis;

        //判断用户是否已中奖或者是否已经填写完资料
        $winner = Yii::$app->redis->hget($redisKey, 'win');
        //-1：已中奖，不能再抽奖 -2：已中奖，请完善资料
        if ($winner > 0)
        {
            return -4;
        }

        //判断是否还有抽奖次数
        $log['times'] = $redis->hget($redisKey, 'times');
        $log['share'] = $redis->hget($redisKey, 'share');
        if ($log)
        {
            if (($log['times'] < $lottery['draw_num']) && (!$lottery['share'] || ($lottery['share'] && !$log['share'])))
                return $lottery['draw_num'] - $log['times'];  //不支持分享或者未分享

            if (($log['times'] < $lottery['draw_num']) && $lottery['share'] && $log['share'])
                return $lottery['draw_num'] - $log['times'] + $lottery['share_add_num'];  //支持分享，并且已分享

            if ($log['times'] == $lottery['draw_num'] && !$lottery['share']) return -7;             //剩余次数为0
            if (!$log['share'] && $lottery['share'] && $lottery['share_add_num'])
            {
                //分享后可增加抽奖次数
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
        return $result;
    }

    public function actionSaveInfo()
    {
        $phone = Yii::$app->request->post('mobile');
        $name = Yii::$app->request->post('name');

        if (!$phone)
        {
            $this->error(-1, '手机号不能为空！');
        }

        if (!$name)
        {
            $this->error(-1, '姓名不能为空！');
        }

        //获取当前活动组和活动ID
        $lotteryGroup = Yii::$app->session->get('lottery_group');
        $lotteryId = Yii::$app->session->get('lottery_active');

        if (!$lotteryId || !$lotteryGroup)
        {
            $this->error(-1, '活动不存在');
        }

        $redis = Yii::$app->redis;
        $lottery = $redis->hget('lottery_group:' . $lotteryGroup, 'lottery_list:' . $lotteryId);

        if (!$lottery)
        {
            $this->error(-1, '活动不存在');
        }

        $lottery = \GuzzleHttp\json_decode($lottery, true);
        //微信用户授权登录
        $this->oauthCheck([
            'app_alias_name' => $lottery['mp_type'],
            'silence' => $lottery['silence'],
            'ajax' => true
        ]);

        $userInfo = Yii::$app->wechat->user;

        //用户活动记录初始化
        $redisKey = 'user:' . $lottery['id'] . ':' . $userInfo->id;
        $redis  = Yii::$app->redis;

        $winnerModel = new \common\models\wxservice\LotteryWinner();
        $winner = $winnerModel->findOne(['act_id' => $lottery['id'], 'open_id' => $userInfo->id]);
        if (!$winner)
        {
            $this->error(-1, '网络忙，请稍后再试！');
        }
        $winner->phone = $phone;
        $winner->name = $name;
        if ($winner->save())
        {
            $redis->hset($redisKey, 'complete', 1);
            $this->success();
        }
        $this->error(-1, '网络忙，请稍后再试！');
    }

    public function actionGetPrize()
    {
        //判断是否在微信内
        if (!$this->_isWechat())
        {
            $this->error(-1, '请在微信内访问本链接');
        }

        //判断是否有传参
        $guid = Yii::$app->request->get('guid');
        if (!$guid)
        {
            $this->error(-1, '活动不存在');
        }

        //直接去数据库获取活动详情，此处的guid是活动的，不是分组的
        $lottery = LotteryList::find()->where(['guid' => $guid])->select(['id', 'mp_type', 'act_name', 'silence', 'bonus'])->one();

        if (!$lottery)
        {
            $this->error(-1, '活动不存在');
        }

        if ($lottery['bonus'])
        {
            $this->error(-1, '红包活动，自动发送红包');
        }

        //微信用户授权登录
        $this->oauthCheck([
                'app_alias_name' => $lottery['mp_type'],
                'silence' => $lottery['silence'],
                'ajax' => true
        ]);

        $userInfo = Yii::$app->wechat->user;

        //获取用户中奖信息
        $winner = LotteryWinner::find()->where(['open_id' => $userInfo->id, 'act_id' => $lottery['id']])->select(['id', 'prize_id', 'modify_time'])->one();
        if (!$winner)
        {
            $this->error(-1, '找不到中奖信息');
        }

        //领奖
        if (Yii::$app->request->isPost)
        {
            if (!$pwd = Yii::$app->request->post('pwd'))
            {
                $this->error(-1, '请输入领奖密码');
            }

            if ($pwd != Yii::$app->redis->get('lottery_prize_pwd:' . $lottery['id']))
            {
                $this->error(-1, '领奖密码不正确');
            }

            LotteryWinner::updateAll(['modify_time' => time()], ['id' => $winner['id']]);
            $this->success(['modify_time' => date('Y-m-d H:i:s')]);
        }

        if ($winner['modify_time']) {
            $this->success([
                    'modify_time' => date('Y-m-d H:i:s', $winner['modify_time']),
                    'name' => $userInfo->nickname,
                    'avatar' => isset($userInfo->original['headimgurl']) ? $userInfo->original['headimgurl'] : '',
                    'title' => $lottery['act_name'],
                    'prizeName' => ''
            ]);
        }

        //获取奖品名称
        $prize = LotteryPrize::find()->where(['id' => $winner['prize_id']])->select(['content'])->one();
        if (!$prize)
        {
            $this->error(-1, '找不到奖品信息');
        }

        $this->success([
                'modify_time' => '',
                'name' => $userInfo->nickname,
                'avatar' => isset($userInfo->original['headimgurl']) ? $userInfo->original['headimgurl'] : '',
                'title' => $lottery['act_name'],
                'prizeName' => $prize['content']
        ]);
    }
}
