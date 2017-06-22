<?php
namespace common\jobs;

use shakura\yii2\gearman\JobBase;
use shakura\yii2\gearman\JobWorkload;

class Activity extends JobBase
{
    public function execute(\GearmanJob $job = null)
    {
        $params = unserialize($job->workload())->params;
        $class = 'common\models\activity\\' . $params['class'];
        $model = new $class;

        //微信用户，如果记录不存在则更新
        if ($params['class'] == 'LotteryWechat')
        {
            $params['data']['openid'] = $params['data']['wx_openid'];
            $model = $model->find()->where(['openid' => $params['data']['openid']])->one();
        }

        //如果是红包抽奖，则生成订单号
        if ($params['class'] == 'LotteryWinner' && $params['data']['bonus_amount'] > 0)
        {
            $params['data']['billno'] = $this->_getBillNo($params['data']['act_id']);
        }

        //如果存在查询条件，则先进行查询操作，只针对单条操作
        if ($params['where'])
        {
            $model = $model->find()->where($params['where'])->one();
            if (!$model) return;
        }
        if (!$model) $model = new $class;
        if (!($model->load($params['data'], '') && $model->save())) return;

        //发送红包操作
        if (isset($params['data']['billno'])
                && $params['data']['billno']
                && isset($params['data']['billno'])
                && $params['data']['send']
        )
        {
            //添加异步发放红包
            \Yii::$app->gearman->getDispatcher()->background('bonus', new JobWorkload([
                    'params' => [
                            'data' => $model->attributes['id']
                    ]
            ]));
        }
    }

    /**
     * @Desc: 获取订单号
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $lot_id
     * @return int|string
     */
    private function _getBillNo($lot_id)
    {
        $bill_no = 10035717;
        $bill_no .= date('mdHis');
        $bill_no .= mt_rand(10, 99);
        $bill_no .= str_pad($lot_id, 6, '0', STR_PAD_LEFT);
        return $bill_no;
    }
}