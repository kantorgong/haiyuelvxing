<?php

namespace common\models\wxservice;

use Yii;
use yii\db\ActiveRecord;

class LotteryLog extends ActiveRecord
{

    public static function tableName()
    {
        return 'lottery_log';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'act_id' => '抽奖活动编号',
            'open_id' => '微信OPENID',
            'ip' => 'IP地址',
            'insert_time' => '添加时间'
        ];
    }

    public function rules()
    {
        return [
            [['act_id', 'insert_time'], 'required'],
            [['id', 'act_id', 'insert_time'], 'integer'],
            [['open_id', 'ip'], 'string'],
        ];
    }

}
