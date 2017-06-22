<?php
/**
* @作者：limj(李绵军)
* @描述：
* @名称：Answer.php
* @版本：1.0
* @时间：17-3-6
*/
namespace backend\modules\wxplus\controllers;

use Yii;
use common\models\activity\ScratchCardRank;
class AnswerController extends \backend\modules\wxplus\components\Controller
{
    public $allDay = ['20170331','20170330','20170329','20170328'];
    // 设置redis 键的前缀
    public $preKey = 'QWERTSF';

    public function actionIndex()
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
                $newTopRank[$date][$key]['nick_name'] = $userInfo['nickname'];
                $newTopRank[$date][$key]['avatar'] = $userInfo['avatar'];
                $newTopRank[$date][$key]['isHave'] = \Yii::$app->redis->sismember($this->__getKey('user_getprize_' . $date), $value);;
            }
        }
        return $this->render('index', ['topRank'=>$newTopRank]);
    }

    public function actionSetrank()
    {
        $model = new ScratchCardRank();
        $post = \Yii::$app->request->post('ScratchCardRank');
        $openId = $post['open_id'];
        $time = $post['mtime'];
        $score = $post['score'];
        if($openId && $time && $score)
        {
            $uAnswerInfoArr['mtime'] = $time;
            $uAnswerInfoArr['score'] = $score;
            $this->recordResult($uAnswerInfoArr, $openId);
            //更新数据库
            $models = ScratchCardRank::find()->where(['open_id'=>$openId, 'date'=>date('Y-m-d')])->one();
            if(!empty($models))
            {
                $models->score = $uAnswerInfoArr['score'];
                $models->mtime = $uAnswerInfoArr['mtime'];
                $models->modify_time = date('Y-m-d H:i:s');
                if($models->save())
                {
                    return $this->redirect(['index']);
                }
            }
        }
        // 获取特定用户
        $userInfo = \Yii::$app->redis->smembers($this->__getKey('getuserinfo'));
        return $this->render('setrank', ['model'=>$model, 'userInfo'=>$userInfo]);
    }

    public function actionSetconf()
    {
        if(\Yii::$app->request->isPost)
        {
            $isOpenRand = intval(\Yii::$app->request->post('isOpenRand'));
            \Yii::$app->redis->set($this->__getKey('isOpenRand'),$isOpenRand);
        }
        $isOpenRand = \Yii::$app->redis->get($this->__getKey('isOpenRand'));
        return $this->render('setconf', ['isOpenRand'=>$isOpenRand]);
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

    /**
     * 描述：计算用户成绩
     */
    private function countResult($score, $mtime)
    {
        return $score * 10000000 + (86400000 - $mtime);
    }
    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }
}