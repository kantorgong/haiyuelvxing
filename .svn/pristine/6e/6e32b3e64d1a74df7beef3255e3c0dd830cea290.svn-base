<?php
/**
 * @File: DataController.php
 * @User: zhujw <zhjw@xxcb.cn>
 * @Date: 2016/11/28 14:55
 * @Desc: 查看数据
 */
namespace console\controllers;

use yii\console\Controller;
use yii;

class DataController extends Controller
{

    public function actionIndex($act_id)
    {
        $count = \common\models\redis\LotteryLog::find()->where(['act_id' => $act_id])->count();
        $times = \common\models\redis\LotteryLog::find()->where(['act_id' => $act_id])->sum('times');
        $winner = \common\models\redis\LotteryWinner::find()->where(['act_id' => $act_id])->count();
        $bonus = \common\models\redis\LotteryWinner::find()->where(['act_id' => $act_id])->sum('bonus_amount');

        echo '参与人数：' . $count . "\r\n";
        echo '抽奖次数：' . $times . "\r\n";
        echo '中奖人数：' . $winner . "\r\n";
        echo '中奖金额：' . $bonus/100 . "\r\n";

        //获取奖等
        $prizeDetail = \common\models\redis\LotteryPrize::find()->where(['act_id' => $act_id])->asArray()->all();
        foreach ($prizeDetail as $pri)
        {
            $prize = \common\models\redis\LotteryWinner::find()->where(['act_id' => $act_id, 'prize_id' => $pri['id']])->count();
            $prize = $prize?$prize:0;
            echo "奖等【{$pri['name']}】中奖数量：{$prize}\r\n";
        }
        die;
    }

    public function actionSearch($nickname)
    {
        \components\XyXy::dump(\common\models\redis\WxsUser::find()->where(['nickname' => $nickname])->asArray()->all());
    }

    /**
     * @Desc: 获取活动大奖列表，每五分钟执行一次
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $guid
     */
    public function actionBigPrizeList($guid)
    {
        $list = \common\models\redis\LotteryWinner::find()
                ->where(['in', 'group_id', ['3795E0E7-A75D-1F18-A4AF-9D676DDD0B66', 'E9D8E0BC-4B60-C109-4B9A-F86F21AD3312']])
                ->andWhere(['in', 'bonus_amount', [5000, 10000, 20000]])
                ->asArray()
                ->all();
        Yii::$app->redis->set('bigPrizeList' . $guid, \GuzzleHttp\json_encode($list));
    }
}