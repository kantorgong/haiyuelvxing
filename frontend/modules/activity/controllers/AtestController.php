<?php
/**
 * AnswerController
 * 作者: limj
 * 版本: 17-2-16
 */

namespace frontend\modules\activity\controllers;
use \Yii;
use common\models\activity\ScratchCardRank;
use components\XyXy;
class AtestController extends \frontend\modules\activity\components\Controller
{
    // 设置redis 键的前缀
    public $preKey = 'QWERTSF';
    // 设置 答题至少时间值(毫秒)
    public $minTime = 3000;
    // 设置最大访问次数(每天)
    public $maxAccess = 1000;
    // 设置活动日期
    public $allDay = ['20170331','20170330','20170329','20170328','20170327','20170326','20170325','20170324','20170323'];

    public function actionIndex()
    {
        //判断是否在微信内
/*        if (!$this->_isWechat() && YII_ENV == 'prod')
        {
            $this->_errorShow('请在微信内打开链接！');
        }*/
        $this->__getOpenId();
        return $this->renderPartial('index');
    }

    /**
     * 描述：开始答题
     */
    public function actionStart()
    {
        $openId = $this->__getOpenId();
        // 初始化用户题目
        $firstQ = $this->__getQuestion($openId);
        // 初始化用户当次答题信息
        $uAnswerInfo = ['start_time' => microtime(true), 'end_time'=>0, 'score'=>0, 'mtime'=>0];
        Yii::$app->redis->hset($this->__getKey('uAnswer_info'), $openId, \GuzzleHttp\json_encode($uAnswerInfo));
        return $this->renderPartial('start', array('question'=>$firstQ));
    }

    /**
     * 描述：ajax 获取题目
     */
    public function actionAjaxQuestion()
    {
        try
        {
            $openId = $this->__getOpenId();

            // 获取答案
            $userRight = md5(trim(\Yii::$app->request->get('right')));
            if(empty($userRight))
            {
                throw new \Exception('请选择一个选项');
            }
            $rightArr = \GuzzleHttp\json_decode(Yii::$app->redis->hget($this->__getKey('user_right_option') , $openId), true);
            // 删除用户答题
            Yii::$app->redis->hset($this->__getKey('user_right_option') , $openId, '');
            if(!empty($rightArr))
            {
                // 答案正确用户 +1
                Yii::$app->redis->hincrby($this->__getKey('user_right_score'), $openId, $rightArr[$userRight]);
            }
            // 获取下一道题目
            $qustion = $this->__getCrruntQuestion($openId);
        }
        catch (\Exception $e)
        {
            return $this->_errorShow($e->getMessage());
        }
        // 获取用户答题时间
        $tempInfo = \GuzzleHttp\json_decode(Yii::$app->redis->hget($this->__getKey('uAnswer_info'), $openId), true);
        $haveTime = floor(microtime(true) - $tempInfo['start_time']);
        // 返回题目、上一题答案是否正确，当前服务器答题时间
        return $this->_successReturn(array('question'=>$qustion, 'time'=>$haveTime));
    }

    /**
     * 描述：排行榜
     */
    public function actionRank()
    {
        $openId = $this->__getOpenId();
        //从redis中获取临时答题信息
        $answerInfo = Yii::$app->redis->hget($this->__getKey('uAnswer_info'), $openId);
        $answerInfoArr = \GuzzleHttp\json_decode($answerInfo, true);
        //获取当前排名前10的人员信息
        $topRank = Yii::$app->redis->zrevrange($this->__getKey('rankMarkSet_' . date('Ymd')), 0, 9);
        $newRank = array();
        foreach($topRank as $key=>$value)
        {
            if(empty($value)) continue;
            $userInfo = \GuzzleHttp\json_decode(\Yii::$app->redis->hget($this->__getKey('user_basic_info'), $value), true);
            $goodMark = \GuzzleHttp\json_decode(Yii::$app->redis->hget($this->__getKey('goodsMark_' . date('Ymd')), $value), true);
            $newRank[$key]['nick_name'] = $userInfo['nickname'] ?:'昵称';
            $newRank[$key]['avatar'] = $userInfo['avatar'] ?: '';
            $newRank[$key]['mtime'] = round($goodMark['mtime']/1000, 1);
            $newRank[$key]['score'] = $goodMark['score'];
        }
        $r = $this->countResult($answerInfoArr['score'], $answerInfoArr['mtime']);
        $rankNum = Yii::$app->redis->zcount($this->__getKey('rankMarkSet_' . date('Ymd')), 0, $r);
        $rankTotal = Yii::$app->redis->zcard($this->__getKey('rankMarkSet_' . date('Ymd')));
        if($rankTotal == 1)
        {
            $baiPer = 100;
        }
        else
        {
            $baiPer = round($rankNum/$rankTotal, 2) * 100;
        }
        return $this->renderPartial('rank',array('newRank'=>$newRank, 'answerInfo'=> $answerInfoArr, 'baiPer'=>$baiPer));
    }


    public function actionNotice()
    {
        return $this->renderPartial('error');
    }

    /**
     * 描述：领取页面
     */
    public function actionPrize()
    {
        $userInfo = Yii::$app->session->get('wxs_userInfo');
        if(empty($userInfo))
        {
            // 跳入微信授权
            $returnUrl = Yii::$app->request->getHostInfo() . '/activity/answer/prize.html';
            Yii::$app->response
                ->redirect(\components\XyXy::getFrontendWebUrl() .
                    '/wechat/oauth/callback.html?appName=94uv&snsApi=snsapi_userinfo&returnUrl=' . urlencode($returnUrl))
                ->send();
            exit;
        }
        $openId = $this->__getOpenId();
        $newTopRank = array();
        foreach($this->allDay as $date)
        {
            //获取当前排名前10的人员信息
            $topRank = Yii::$app->redis->zrevrange($this->__getKey('rankMarkSet_' . $date), 0, 9);
            if(empty($topRank)) continue;
            $index = array_search($openId, $topRank);
            if($index === false) continue;
            // 名次等级
            $rank = $index + 1;
            $userInfo = \GuzzleHttp\json_decode(\Yii::$app->redis->hget($this->__getKey('user_basic_info'), $openId), true);
            $newTopRank[$date]['nick_name'] = $userInfo['nickname'];
            $newTopRank[$date]['avatar'] = $userInfo['avatar'];
            $newTopRank[$date]['date'] = date('Y年m月d日', strtotime($date));
            $newTopRank[$date]['prize'] = 'U盘一个';
            // 已领取 返回1 ，未领取返回0
            $newTopRank[$date]['isHave'] = \Yii::$app->redis->sismember($this->__getKey('user_getprize_' . $date), $openId);
        }
        return $this->renderPartial('prize', array('newTopRank'=>$newTopRank));
    }

    /**
     * 描述：获取用户信息
     */
    public function actionGetuser()
    {
        $userInfo = Yii::$app->session->get('wxs_userInfo');
        if(empty($userInfo))
        {
            // 跳入微信授权
            $returnUrl = Yii::$app->request->getHostInfo() . '/activity/answer/getuser.html';
            Yii::$app->response
                ->redirect(\components\XyXy::getFrontendWebUrl() .
                    '/wechat/oauth/callback.html?appName=94uv&snsApi=snsapi_userinfo&returnUrl=' . urlencode($returnUrl))
                ->send();
            exit;
        }
        \Yii::$app->redis->sadd($this->__getKey('getuserinfo'),$userInfo);
        return $this->redirect('index.html');
    }

    public function actionAjaxPrize()
    {

        $openId = $this->__getOpenId();
        $date = \Yii::$app->request->get('datetime');
        if(empty($date)) $this->_failReturn('当前日期没有中奖信息');
        if(!in_array($date, $this->allDay)) $this->_failReturn('中奖日期不在活动时间范围内！');
        // 成功返回1 失败返回0;
        $res = \Yii::$app->redis->sadd($this->__getKey('user_getprize_' . $date), $openId);
        if($res == 1)
        {
            $this->_successReturn('恭喜您！领取成功');
        }
        else
        {
            $this->_failReturn('奖品领取失败！');
        }
    }

    /**
     * 描述：不在时间段的跳转页面
     */
    public function actionRanklist()
    {
        $newTopRank = array();
        foreach($this->allDay as $date)
        {
            //获取当前排名前10的人员信息
            $topRank = Yii::$app->redis->zrevrange($this->__getKey('rankMarkSet_' . $date), 0, 9);
            if(empty($topRank)) continue;
            foreach($topRank as $key=>$value)
            {
                $userInfo = \GuzzleHttp\json_decode(\Yii::$app->redis->hget($this->__getKey('user_basic_info'), $value), true);
                $goodMark = \GuzzleHttp\json_decode(Yii::$app->redis->hget($this->__getKey('goodsMark_' . $date), $userInfo['id']), true);
                $newTopRank[$date][$key]['nick_name'] = $userInfo['nickname'];
                $newTopRank[$date][$key]['avatar'] = $userInfo['avatar'];
                $newTopRank[$date][$key]['mtime'] = round($goodMark['mtime']/1000, 1);
                $newTopRank[$date][$key]['score'] = $goodMark['score'];
            }
        }
        $date = date('Ymd');
        $currentDay = $newTopRank[$date];
        unset($newTopRank[$date]);
        return $this->renderPartial('ranklist',array('topRank'=>$newTopRank, 'currentDay'=>$currentDay));
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

        $userInfo = Yii::$app->request->get('wxs_userInfo');
        // @todo 用于测试
        if(empty($userInfo))
        {
            $userInfo = '{"id": "1000000","nickname": "li","avatar": "http://www.baidu.com"}';
        }
        if(\Yii::$app->request->isAjax)
        {
            if(empty($userInfo))
            {
                throw new \Exception('您访问页面已过期，请重新进入！');
            }
        }
        else
        {

            // 检查是否在活动开启时间段
            $crrTime = date('G');
            // 检查日期
            $crrDate = date('Y-m-d');
            if($crrTime<9 || $crrTime >= 22)
            {
                // @todo 跳入新页面
                return $this->redirect('ranklist.html');
            }

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

    /**
     * 描述：初始化用户题目
     */
    private function __getQuestion($openId)
    {
        // 获取所有题目
        $questionStr = Yii::$app->redis->hget($this->__getKey('answer_question') , 'question');
        $questionArr = \GuzzleHttp\json_decode($questionStr, true);
        //随机一个数值
        shuffle($questionArr);
        $userQuestion = array_slice($questionArr, 0, 8);
        $first = array_shift($userQuestion);
        // 设置单个用户答题题目
        Yii::$app->redis->hset($this->__getKey('user_question'), $openId, \GuzzleHttp\json_encode($userQuestion));
        // 保存该题的正确答案
        Yii::$app->redis->hset($this->__getKey('user_right_option'), $openId, \GuzzleHttp\json_encode($first['right']));
        // 初始化分值
        \Yii::$app->redis->hset($this->__getKey('user_right_score'), $openId, 0);
        unset($first['right']);
        $optionArr = $first['option'];
        shuffle($optionArr);
        $first['option'] = $optionArr;
        return $first;
    }

    /**
     * 描述：获取当前题目
     */
    private function __getCrruntQuestion($openId)
    {
        // 获取剩余
        $questionStr = Yii::$app->redis->hget($this->__getKey('user_question'), $openId);
        $questionArr = \GuzzleHttp\json_decode($questionStr, true);
        if(empty($questionArr))
        {
            // 用户答题完成记录用户结束时间
            $uAnswerInfo = Yii::$app->redis->hget($this->__getKey('uAnswer_info'), $openId);
            $uAnswerInfoArr = \GuzzleHttp\json_decode($uAnswerInfo, true);
            $uAnswerInfoArr['end_time'] = microtime(true);
            $uAnswerInfoArr['mtime'] = round($uAnswerInfoArr['end_time'] - $uAnswerInfoArr['start_time'], 3) * 1000 ;
            $uAnswerInfoArr['score'] = \Yii::$app->redis->hget($this->__getKey('user_right_score'), $openId);
            // 判断用户答题是否是机器答题
            if($uAnswerInfoArr['mtime'] < $this->minTime)
            {
                //视为机器答题。答题作废
                throw new \Exception('您的答题无效！');
            }
            // 设置本次答题信息
            Yii::$app->redis->hset($this->__getKey('uAnswer_info'), $openId, \GuzzleHttp\json_encode($uAnswerInfoArr));
            // 获取当天最好成绩
            $goodsMark = Yii::$app->redis->hget($this->__getKey('goodsMark_' . date('Ymd')), $openId);
            if(empty($goodsMark))
            {
                // 为空，说明用户首次玩，记录用户当次成绩到redis 并且保存到mysql
                $this->recordResult($uAnswerInfoArr, $openId);
                $model = new ScratchCardRank();
                $model->score = $uAnswerInfoArr['score'];
                $model->mtime = $uAnswerInfoArr['mtime'];
                $model->date = date('Y-m-d');
                $model->open_id = $openId;
                $model->modify_time = date('Y-m-d H:i:s');
                $model->ip = \Yii::$app->request->getUserIP();
                $model->save();
            }
            else
            {
                // 不为空，判断用户是否比上次成绩更好，如果更好保存最新记录
                $goodsArr = \GuzzleHttp\json_decode($goodsMark, true);
                if(($uAnswerInfoArr['score'] > $goodsArr['score']) || ($uAnswerInfoArr['score'] == $goodsArr['score'] && $uAnswerInfoArr['mtime'] < $goodsArr['time']))
                {
                    $this->recordResult($uAnswerInfoArr, $openId);
                    //更新数据库
                    $model = ScratchCardRank::find()->where(['open_id'=>$openId, 'date'=>date('Y-m-d')])->one();
                    $model->score = $uAnswerInfoArr['score'];
                    $model->mtime = $uAnswerInfoArr['mtime'];
                    $model->modify_time = date('Y-m-d H:i:s');
                    $model->save();
                }

            }
            // 设置答题结束标示
            Yii::$app->redis->hset($this->__getKey('uAnswer_token'), $openId, 'end');

            // 返回空数组，用户跳入排名页面
            return null;
        }

        //随机一个数值
        shuffle($questionArr);
        $first = array_shift($questionArr);
        // 设置单个用户题目
        Yii::$app->redis->hset($this->__getKey('user_question'), $openId, \GuzzleHttp\json_encode($questionArr));
        // 保存答案
        Yii::$app->redis->hset($this->__getKey('user_right_option'), $openId, \GuzzleHttp\json_encode($first['right']));
        unset($first['right']);
        $optionArr = $first['option'];
        shuffle($optionArr);
        $first['option'] = $optionArr;
        return $first;
    }

    /**
     * 描述：计算用户成绩
     */
    private function countResult($score, $mtime)
    {
        return $score * 10000000 + (86400000 - $mtime);
    }

    /**
     * 描述：记录用户当天最好成绩
     */
    private function recordResult($uAnswerInfoArr, $openId)
    {
        $goodsArr['mtime'] = $uAnswerInfoArr['mtime'];
        $goodsArr['score'] = $uAnswerInfoArr['score'];
        Yii::$app->redis->hset($this->__getKey('goodsMark_' . date('Ymd')), $openId, \GuzzleHttp\json_encode($goodsArr));
        $rankNum = $this->countResult($uAnswerInfoArr['score'], $uAnswerInfoArr['mtime']);
        // 记录一个有序集合用于用户排名
        Yii::$app->redis->zadd($this->__getKey('rankMarkSet_' . date('Ymd')), $rankNum, $openId);
    }

    /*
    public function actionDel()
    {
        // 删除用户基本信息
        //\Yii::$app->redis->expire($this->__getKey('user_basic_info'), 1);
        // 删除排名前10的
//        $res = \Yii::$app->redis->hdel($this->__getKey('rankMarkSet_' . date('Ymd')));
        // 删除最好成绩
//        $res = \Yii::$app->redis->expire($this->__getKey('goodsMark_' . date('Ymd')), 1);
        // 删除抽奖次数
        $res = \Yii::$app->redis->expire($this->__getKey('userPrize_num_' . date('Ymd')), 1);
        // 删除分享次数
        $res = \Yii::$app->redis->expire($this->__getKey('userShare_num_' . date('Ymd')), 1);

        $res = Yii::$app->redis->expire($this->__getKey('uhave_Prize_' . date('Ymd')), 1);
        var_dump($res);die;
    }
*/
    // @todo 用于测试
    public function actionAjaxQuestiont()
    {
        try
        {
            $openId = $this->__getOpenId();
            //throw new \Exception('请选择一个选项');
            // @todo 用于测试
            $restt = Yii::$app->redis->hget($this->__getKey('user_question_isstart'), $openId);
            if(empty($restt))
            {

                // 初始化用户题目
                $firstQ = $this->__getQuestion($openId);
                // 初始化用户当次答题信息
                $uAnswerInfo = ['start_time' => microtime(true)-3600, 'end_time'=>0, 'score'=>0, 'mtime'=>0];
                Yii::$app->redis->hset($this->__getKey('uAnswer_info'), $openId, \GuzzleHttp\json_encode($uAnswerInfo));
            }
            // @todo 用于测试
            if(\Yii::$app->request->get('right'))
            {
                // 获取答案
                $userRight = md5(trim(\Yii::$app->request->get('right')));
            }
            else
            {
                $userRight = md5(microtime(true));
            }

            $rightArr = \GuzzleHttp\json_decode(Yii::$app->redis->hget($this->__getKey('user_right_option') , $openId), true);
            // 删除用户答题
            Yii::$app->redis->hset($this->__getKey('user_right_option') , $openId, '');
            if(!empty($rightArr))
            {
                // 答案正确用户 +1
                Yii::$app->redis->hincrby($this->__getKey('user_right_score'), $openId, $rightArr[$userRight]);
            }
            // 获取下一道题目
            $qustion = $this->__getCrruntQuestion($openId);
        }
        catch (\Exception $e)
        {
            return $this->_errorShow($e->getMessage());
        }
        // 获取用户答题时间
        $tempInfo = \GuzzleHttp\json_decode(Yii::$app->redis->hget($this->__getKey('uAnswer_info'), $openId), true);
        $haveTime = floor(microtime(true) - $tempInfo['start_time']);
        // @todo 用于测试
        if($qustion)
        {
            Yii::$app->redis->hset($this->__getKey('user_question_isstart'), $openId, true);
            return 1;
        }
        else
        {
            Yii::$app->redis->hset($this->__getKey('user_question_isstart'), $openId, false);
            return 1;
        }
    }

}