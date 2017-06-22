<?php
/**
 * scratchCardController
 * 作者: limj
 * 版本: 17-2-20
 */

namespace frontend\modules\activity\controllers;
use \Yii;
use common\models\activity\ScratchCardPrize;
use components\XyXy;
class ScratchCardController extends \frontend\modules\activity\components\Controller
{
    // 设置redis 键的前缀
    public $preKey = 'QWERTSF';
    // 设置 答题至少时间值(毫秒)
    public $minTime = 3000;
    // 设置最大访问次数(每天)
    public $maxAccess = 1000;
    public $allDay = ['20170331','20170330','20170329','20170328'];

    public function actionIndex()
    {
        // 判断是否在微信内
        if (!$this->_isWechat())
        {
            $this->_errorShow('请在微信内打开链接！');
        }
        // 获取用户openId
        $openId = $this->__getOpenId();
        // 校验用户是否有权限刮卡
        $result = $this->__checkScratch($openId);
        return $this->renderPartial('index', array('result'=>$result));
    }

    /**
     * 描述：ajax 请求刮卡
     */
    public function actionAjaxCard()
    {
        // @todo 各种权限限制条件校验 IP是否为湖南等等...
        $openId = $this->__getOpenId();
        // 校验用户是否有权限刮卡
        $result = $this->__checkScratch($openId);
        if($result !== true)
        {
            return $this->_failReturn($result);
        }
        // 用户抽奖,判断用户是否已经中奖
        $rePrize = Yii::$app->redis->hget($this->__getKey('uhave_Prize_' . date('Ymd')), $openId);
        // 判断用户是否属于发红包记录黑名单
        $blackUser = Yii::$app->redis->sismember($this->__getKey('user_sendError'), $openId);
        if($rePrize == 1 || $blackUser == 1)
        {
            // 已经中奖的用户第二次抽奖
            $prize = 0;
        }
        else
        {
            // 从奖池队列中获取红包
            $prize = Yii::$app->redis->lpop($this->__getKey('prize_queue_' . date('Ymd')));
            if($prize == null)
            {
                // 奖池为空默认所有人抽奖中奖金额为0
                $prize = 0;
            }
        }
        if($prize >= 0.01)
        {
            //记录用户中奖信息
            $model = new ScratchCardPrize();
            $model->open_id = $openId;
            $model->money = $prize;
            $model->ip = \Yii::$app->request->getUserIP();
            $model->date = date('Y-m-d');
            $model->status = 1;
            $model->insert_time = date('Y-m-d H:i:s');
            $model->send_time = 0;
            $model->save();
            // 标示用户中奖信息到redis
            Yii::$app->redis->hset($this->__getKey('uhave_Prize_' . date('Ymd')), $openId, 1);
        }
        //更新用户抽奖次数
        Yii::$app->redis->hincrby($this->__getKey('userPrize_num_' . date('Ymd')), $openId, 1);
        //删除答题结束标示
//        Yii::$app->redis->hdel($this->__getKey('uAnswer_token'), $openId);

        return $this->_successReturn(array('money'=>$prize,
            'isClick'=>Yii::$app->redis->hget($this->__getKey('userPrize_num_' . date('Ymd')), $openId),
            'isShare'=>Yii::$app->redis->hget($this->__getKey('userShare_num_' . date('Ymd')), $openId)));
    }

    /**
     * 描述：分享回调
     */
    public function actionShare()
    {
        $openId = $this->__getOpenId();
        $shareNum = Yii::$app->redis->hincrby($this->__getKey('userShare_num_' . date('Ymd')), $openId, 1);
/*        if($shareNum <= 2)
        {
            Yii::$app->redis->hset($this->__getKey('uAnswer_token'), $openId, 'end');
        }*/
        return 1;
    }

    private function __checkScratch($openId)
    {
        return '本次抽奖活动已结束,下次请赶早哦!';
        // 判断用户是否刚从答题页面跳入过来
        $userFrom = Yii::$app->redis->hget($this->__getKey('uAnswer_token'), $openId);
        if($userFrom != 'end')
        {
            // @用户不是正常来自答题页面，默认让用户跳入答题首页开始答题
            return '请先答题！';
        }
        // 校验用户当次答题时间是否在正常范围内
        $uAnswerInfo = Yii::$app->redis->hget($this->__getKey('uAnswer_info'), $openId);
        $uAnswerInfoArr = \GuzzleHttp\json_decode($uAnswerInfo, true);
        if($uAnswerInfoArr['mtime'] < $this->minTime)
        {
            return '答题无效！';
        }
        $ipregion = new \components\helper\Ip2region(\components\XyXy::getIpdb());
        $region = $ipregion->btreeSearch(XyXy::getIp())['region'];
//        $region = $ipregion->btreeSearch('116.240.254.2')['region'];
        if (strpos($region, '湖南省') === false)
        {
            return '您所在的地区不支持该活动！';
        }
        // 判断用户是否有刮卡机会
        $prizeNum = Yii::$app->redis->hget($this->__getKey('userPrize_num_' . date('Ymd')), $openId);
        if($prizeNum >= 2)
        {
            // 提醒用户今天没有刮卡次数了
            return '您今天的刮卡次数达上限！';
        }
        elseif ($prizeNum == 1)
        {
            // 获取用户是否当天有分享 +1
            $shareNum = Yii::$app->redis->hget($this->__getKey('userShare_num_' . date('Ymd')), $openId);
            if($shareNum < 1)
            {
                //提醒用户分享朋友圈可以获取一次刮卡机会
                return '分享朋友圈可以获得一次刮卡机会';
            }
        }
        return true;
    }

    private function __getOpenId()
    {
        $isRand = Yii::$app->redis->get($this->__getKey('isOpenRand'));
        if ($isRand >= 1)
        {
            $mtRand = mt_rand(1, 100);
            if($mtRand <= $isRand)
            {
                if(\Yii::$app->request->isAjax)
                {
                    // 直接拒绝请求
                    die;
                }
                else
                {
                    // 跳入404
                    return $this->redirect('notice.html');
                }
            }
        }

        $userInfo = Yii::$app->session->get('wxs_userInfo');
        // 检查是否在活动开启时间段
        $crrTime = date('G');
        // 检查日期
        $crrDate = date('Ymd');
        if(\Yii::$app->request->isAjax)
        {
            if($crrTime<9 || $crrTime >= 22)
            {
                // @todo 跳入新页面
                die;
            }
            // @todo 判断是否在活动时间范围内
            /*            if(!in_array($crrDate, $this->allDay))
                        {
                            die;
                        }*/
            if(empty($userInfo))
            {
                throw new \Exception('您访问页面已过期，请重新进入！');
            }
        }
        else
        {
            if($crrTime<9 || $crrTime >= 22)
            {
                // @todo 跳入新页面
                return $this->redirect('ranklist.html');
            }
            /*            if(!in_array($crrDate, $this->allDay))
                        {
                            return $this->redirect('ranklist.html');
                        }*/
            if(empty($userInfo))
            {
                // 跳入微信授权
                $returnUrl = Yii::$app->request->getHostInfo() . '/activity/answer/index.html';
                Yii::$app->response
                    ->redirect(\components\XyXy::getFrontendWebUrl() .
                        '/wechat/oauth/callback.html?appName=94uv&snsApi=snsapi_userinfo&returnUrl=' . urlencode($returnUrl))
                    ->send();
                exit;
            }
        }
        $userInfoArr = \GuzzleHttp\json_decode($userInfo, true);
        $openId = $userInfoArr['id'];
        $blackList = Yii::$app->redis->smembers($this->__getKey('user_blackList'));
        if(in_array($openId, $blackList))
        {
            //黑名单直接拒绝
            $this->_errorShow('非法访问！');
        }
        // 记录用户访问次数
        $accessNum = Yii::$app->redis->hincrby($this->__getKey('user_accessNum_' . date("Ymd")), $openId, 1);
        if($accessNum >= $this->maxAccess)
        {
            // 记录用户到黑名单
            Yii::$app->redis->sadd($this->__getKey('user_blackList'), $openId);
        }
        // 记录用户信息
        Yii::$app->redis->hsetnx($this->__getKey('user_basic_info'), $openId, $userInfo);
        return $openId;
    }

    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }

} 