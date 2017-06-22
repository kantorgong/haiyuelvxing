<?php
/**
 * ScratchRedController
 * 作者: limj
 * 版本: 17-2-22
 */

namespace console\controllers;
use yii;
use yii\console\Controller;
use common\models\activity\ScratchCardPrize;
use EasyWeChat\Foundation\Application;
class ScratchRedController extends Controller
{
    // 设置redis 键的前缀
    public $preKey = 'QWERTSF';

    public $luckyMoneyData = [
        'mch_billno'       => 'xy123456',
        'send_name'        => '潇湘晨报258理财俱乐部',
        're_openid'        => '',
        'total_amount'     => 100,  //单位为分，不小于100
        'wishing'          => '放心理财好生活',
        'act_name'         => '潇湘晨报258理财俱乐部',
        'remark'           => '潇湘晨报258理财俱乐部',
        // ...
    ];
    public function actionIndex()
    {
        $starting = Yii::$app->redis->get($this->__getKey('Start_SendRed'));
        if($starting == 1)
        {
            // 程序正在执行发红包.....
            $this->stdout("程序正在执行发红包.....\n");
            return;
        }
        // 开启发红包标示
        Yii::$app->redis->set($this->__getKey('Start_SendRed'), 1);
        $redList = ScratchCardPrize::find()
            ->select('open_id, money,log_id')
            ->where(['date'=>date('Y-m-d'), 'status'=>1])
            ->limit(50)
            ->asArray()
            ->all();
        if(empty($redList)){
            Yii::$app->redis->del($this->__getKey('Start_SendRed'));
            return;
        }
        $luckyMoney = new Application(Yii::$app->params['wechat']['94uv']);
        foreach ($redList as $key=>$val)
        {
            $this->luckyMoneyData['mch_billno'] = $this->_getBillNo($key, $val['log_id']);
            $this->luckyMoneyData['re_openid'] = $val['open_id'];
            // 单位是分
            $this->luckyMoneyData['total_amount'] = $val['money']*100;
            $return = $luckyMoney->lucky_money->sendNormal($this->luckyMoneyData);
            $model = ScratchCardPrize::findOne($val['log_id']);
            if($return->return_code == 'SUCCESS' && $return->result_code == 'SUCCESS')
            {
                // 更新数据库状态
                $model->status = 2;
            }
            else
            {
                $model->status = 3;
                \components\XyXy::log($return, 'send_bonus_error');
                // 记录用户账户异常类型的
                if($return->err_code == 'NO_AUTH')
                {
                    Yii::$app->redis->sadd($this->__getKey('user_sendError'), $val['open_id']);
                }
            }
            $model->return_log = \GuzzleHttp\json_encode($return);
            if(!$model->save())
            {
                // 数据库更新失败
                \components\XyXy::log(array_merge($model->getErrors(), array('info'=>$val,'time'=>date('Y-m-d H:i:s'))), 'send_mysql_error');
                $this->stdout("执行失败\n");
                \Yii::$app->end();
                return;
            }
        }
        // 正常结束删除冻结标示
        Yii::$app->redis->del($this->__getKey('Start_SendRed'));
        $this->stdout("执行成功\n");
    }


    private function _getBillNo($key, $lot_id)
    {
        $bill_no = Yii::$app->params['wechat']['94uv']['payment']['merchant_id'];
        $bill_no .= date('mdHis');
        $bill_no .= str_pad($key, 4, '0', STR_PAD_LEFT);
        $bill_no .= str_pad($lot_id, 4, '0', STR_PAD_LEFT);
        return $bill_no;
    }

    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }
} 