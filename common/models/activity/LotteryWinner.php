<?php

namespace common\models\activity;

use common\models\wxservice\LotteryList;
use Yii;
use yii\db\ActiveRecord;

class LotteryWinner extends ActiveRecord
{

    public static function tableName()
    {
        return 'lottery_winner';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'act_id' => '抽奖活动编号',
            'prize_id' => '奖项编号',
            'open_id' => '微信OPENID',
            'billno' => '红包订单号',
            'bonus_amount' => '红包金额',
            'is_share' => '是否已分享',
            'name' => '姓名',
            'phone' => '手机号',
            'insert_time' => '中奖时间',
            'modify_time' => '领奖时间',
        ];
    }

    public function rules()
    {
        return [
            [['act_id', 'open_id', 'insert_time'], 'required'],
            [['id', 'act_id', 'prize_id', 'bonus_amount', 'modify_time', 'is_share', 'insert_time'], 'integer'],
            [['open_id', 'billno', 'name', 'phone', 'card_id'], 'string'],
        ];
    }

    public function getPrize()
    {
        return $this->hasOne(LotteryPrize::className(), ['id'=>'prize_id'])->select('name');
    }


}