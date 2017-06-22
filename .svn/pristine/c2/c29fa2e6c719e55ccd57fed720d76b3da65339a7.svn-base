<?php
/**
 * PrizeController
 * 作者: limj
 * 版本: 17-2-22
 */

namespace console\controllers;
use yii;
use yii\console\Controller;
use common\models\activity\ScratchCardPrize;

class PrizeController extends Controller
{
    // 设置redis 键的前缀
    public $preKey = 'QWERTSF';
    // 每天红包总金额
    public $money = 400;
    // 每个红包金额
    public $sigleRed = 2;
    // 定义当天最大红包金额
    public $maxMoney = 2000;
    /**
     * 描述：每天凌晨01:00 执行奖金池分配
     */
    public function actionIndex($per=20,$m=0)
    {
        $this->money = $m;
        if($per >= 100)
        {
            $this->stdout("中奖概率设置有误请核实后在执行......\n");
            return;
        }
        // 获取当天已发红包数量
        $redNum = ScratchCardPrize::find()->where(['date'=>date('Y-m-d')])->count();
        // 统计当天已发送总金额
        $totalMoney = $redNum * $this->sigleRed;
        if($totalMoney >= $this->maxMoney)
        {
            $this->stdout("今天发送红包已超过上限，请停止生成红包队列\n");
            return;
        }
        $haveMoney = $this->maxMoney - $totalMoney;

        if($haveMoney < $m)
        {
            $this->money = $haveMoney;
        }
        // 统计应该发送红包数
        $totalNum = floor(($this->money/$this->sigleRed));
        if($totalNum < 1) return;
        // 计算奖池总数量
        $totalPrize = floor($totalNum/($per/100));
        $randPrize = array_fill(0, $totalPrize, 0);
        $prizeAll = array_fill(0, $totalNum, $this->sigleRed);
        foreach($prizeAll as $key=>$value)
        {
            $randPrize[$key] = $value;
        }
        shuffle($randPrize);
        shuffle($randPrize);
        Yii::$app->redis->del($this->__getKey('prize_queue_' . date('Ymd')));
        foreach($randPrize as $val)
        {
            // 插入当天红包队列
            Yii::$app->redis->rpush($this->__getKey('prize_queue_' . date('Ymd')), $val);
        }
        var_dump($randPrize);
    }

    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }
} 