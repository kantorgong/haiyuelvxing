<?php
/**
 * 车展贪吃蛇H5活动
 */
namespace frontend\modules\activity\controllers;

use components\XyXy;
use Yii;
use yii\base\ErrorException as Exception;
use yii\web\NotFoundHttpException;
use \common\models\wxplus\CarSnakeLog;
use \common\models\wxplus\CarSnakePlayLog;

class CarShowController extends \frontend\modules\activity\components\Controller
{
    public $layout = false;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @Desc: H5初始化
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionIndex()
    {
        //判断是否在微信内
        if (!$this->_isWechat())
        {
            $this->_errorShow('请在微信内打开链接！');
        }

        //微信用户授权登录
        $userInfo = Yii::$app->session->get('wxs_userInfo');

        if (!$userInfo)
        {
            $returnUrl = Yii::$app->request->getAbsoluteUrl();
            Yii::$app->response
                    ->redirect(\components\XyXy::getFrontendWebUrl() .
                            '/wechat/oauth/callback.html?appName=94uv&snsApi=snsapi_userinfo&returnUrl=' . urlencode($returnUrl))
                    ->send();
            exit;
        }

        return $this->renderPartial('index');
    }

    /**
     * @Desc: 游戏操作流程
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionOperation()
    {
        $openId = Yii::$app->session->get('wxs_openId');
        if (!$openId)
        {
            $this->_failReturn('请先登录!');
        }

        //ajax来源判断
        $refer = $_SERVER['HTTP_REFERER'];
        if (strpos($refer, XyXy::getFrontendWebUrl()) === false)
        {
            $this->_failReturn('非法请求，拒绝访问!');
        }

        $type = Yii::$app->request->post('type');
        if (!$type) $this->_failReturn('参数错误!');

        $redis = Yii::$app->redis;
        $now = time();

        //开始活动
        if ($type == 'start')
        {
            //删除原有数据
            $oldKey = $redis->get($this->redisKey($openId));
            if ($oldKey)
            {
                $redis->del($oldKey);
            }

            //初始化一条新数据
            $guid = $this->_createGuid();
            $redis->set($this->redisKey($openId), $guid);
            $process[] = $now;
            $redis->hmset($guid, 'total', 0, 'init_time', $now, 'process', \GuzzleHttp\json_encode($process));
            $this->_successReturn('操作成功！');
        }

        //增加吃到的食物数量
        if ($type == 'eat')
        {
            $guid = $redis->get($this->redisKey($openId));
            if (!$guid) $this->_failReturn('参数错误!');
            $init_time = $redis->hget($guid, 'init_time');
            $server_last_time = $now - $init_time;
            if ($server_last_time > 120)
            {
                $this->_failReturn('已超时');
            }
            $total = $redis->hincrby($guid, 'total', 1);
            $process = \GuzzleHttp\json_decode($redis->hget($guid, 'process'), true);
            array_push($process, $now);
            $redis->hset($guid, 'process', \GuzzleHttp\json_encode($process));
            $this->_successReturn($total);
        }

        //游戏结束
        if ($type == 'end')
        {
            $client_last_time = Yii::$app->request->post('last');
            $guid = $redis->get($this->redisKey($openId));
            if (!$guid) $this->_failReturn('参数错误!');
            if (!$client_last_time) $this->_failReturn('参数错误!');
            $total = $redis->hget($guid, 'total');
            $init_time = $redis->hget($guid, 'init_time');
            $server_last_time = $now - $init_time;
            $server_last_time = $server_last_time > 120 ? 120 : $server_last_time;

            $userInfo = Yii::$app->session->get('wxs_userInfo');
            $userInfo = \GuzzleHttp\json_decode($userInfo, true);

            $process = \GuzzleHttp\json_decode($redis->hget($guid, 'process'), true);
            array_push($process, $now);

            $data = [
                    'open_id' => $openId,
                    'nickname' => $userInfo['nickname'],
                    'json_nickname' => \GuzzleHttp\json_encode($userInfo['nickname']),
                    'header' => substr($userInfo['original']['headimgurl'], 0, -1) . '64',
                    'start_time' => $init_time,
                    'insert_time' => $now,
                    'total' => $total,
                    'server_last_time' => $server_last_time,
                    'client_last_time' => $client_last_time,
                    'score' => $this->createScore($total, $server_last_time, $now),
                    'process' => \GuzzleHttp\json_encode($process),
                    'ip' => Yii::$app->request->userIP
            ];

            //保存游戏记录
            $logMod = new CarSnakePlayLog();
            $logMod->load($data, '') && $logMod->save();

            //获取今天我的记录
            $myInfo = CarSnakeLog::find()
                    ->where(['>', 'insert_time', strtotime(date('Y-m-d 00:00:00'))])
                    ->andWhere(['open_id' => $openId])
                    ->one();

            if (!$myInfo)
            {
                //将结果记录到Mysql数据库
                $mod = new CarSnakeLog;
                $mod->load($data, '') && $mod->save();
            }
            else
            {
                $newScore = $this->createScore($total, $server_last_time, $now);
                if ($newScore > $myInfo->score)
                {
                    $myInfo->start_time = $init_time;
                    $myInfo->insert_time = $now;
                    $myInfo->total = $total;
                    $myInfo->server_last_time = $server_last_time;
                    $myInfo->client_last_time = $client_last_time;
                    $myInfo->score = $newScore;
                    $myInfo->save();
                }
            }

            $record = $redis->incr('record:total');
            $this->_successReturn(['total' => $total, 'time' => $server_last_time, 'record' => $record]);
        }
    }

    /**
     * @Desc: 排行
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionRank()
    {
        $openId = Yii::$app->session->get('wxs_openId');
        if (!$openId)
        {
            $this->_failReturn('请先登录!');
        }

        //ajax来源判断
        $refer = $_SERVER['HTTP_REFERER'];
        if (strpos($refer, XyXy::getFrontendWebUrl()) === false)
        {
            $this->_failReturn('非法请求，拒绝访问!');
        }

        //排行榜
        $now = strtotime(date('Y-m-d 00:00:00'));
        $list = CarSnakeLog::find()
                ->where(['>', 'insert_time', $now])
                ->orderBy(['score' => SORT_DESC])
                ->select(['nickname', 'header', 'total', 'server_last_time as time'])
                ->asArray()
                ->limit(10)
                ->all();
        //首先获取活动开始时间
        $first = CarSnakeLog::find()->select('insert_time')->one();
        $from = strtotime(date('Y-m-d 00:00:00', time() - 86400));

        $prize = [];
        $num = 0;
        while ($from > $first && $num < 8)
        {
            //中奖名单
             $ret = CarSnakeLog::find()
                    ->andWhere(['between', 'insert_time', $from, $from + 86400])
                    ->orderBy(['score' => SORT_DESC])
                    ->select(['nickname', 'header', 'total', 'server_last_time as time'])
                    ->asArray()
                    ->limit(3)
                    ->all();
            $from -= 86400;
            $ret && $num++ && $prize[date('m月d日', $from)] = $ret;
        }
        $prize && krsort($prize);

        //我的排名
        $scoreInfo = CarSnakeLog::find()
                ->where(['>', 'insert_time', $now])
                ->andWhere(['open_id' => $openId])
                ->asArray()
                ->select(['score', 'nickname', 'header', 'total', 'server_last_time as time'])
                ->one();

        if ($scoreInfo)
        {
            $scoreInfo['rank'] = CarSnakeLog::find()
                    ->where(['>', 'insert_time', $now])
                    ->andWhere(['>=', 'score', $scoreInfo['score']])
                    ->orderBy(['score' => SORT_DESC])
                    ->count();
        }
        else
        {
            $userInfo = Yii::$app->session->get('wxs_userInfo');
            $userInfo = \GuzzleHttp\json_decode($userInfo, true);
            $scoreInfo['rank'] = '?';
            $scoreInfo['total'] = '?';
            $scoreInfo['time'] = 120;
            $scoreInfo['nickname'] = $userInfo['nickname'];
            $scoreInfo['header'] = $userInfo['original']['headimgurl'];
        }

        $this->_successReturn([
            'list' => $list,
            'rank' => $scoreInfo,
            'prize' => $prize
        ]);
    }

    /**
     * @Desc: 返回redis Key
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $open_id
     * @return string
     */
    protected function redisKey($open_id)
    {
        return md5($open_id .'_carShow_');
    }

    /**
     * @Desc: 根据数量，时长和开始时间计算得分
     * @User: zhujw <zhjw@xxcb.cn>
     */
    protected function createScore($total, $last, $start_time)
    {

        return $total * 100000000 + (120 - $last) * 100000 + strtotime(date('Y-m-d')) + 86400 - $start_time;
    }

    /**
     * @Desc: 生成GUID
     * @User: zhujw <zhjw@xxcb.cn>
     * @return string
     */
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
