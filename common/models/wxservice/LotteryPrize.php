<?php

namespace common\models\wxservice;

use Yii;
use yii\db\ActiveRecord;

class LotteryPrize extends ActiveRecord
{

    public static function tableName()
    {
        return 'lottery_prize';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'act_id' => '抽奖活动编号',
            'name' => '奖项',
            'content' => '奖品',
            'bonus_amount' => '红包金额(分)',
            'num' => '实际数量',
            'num_show' => '显示数量',
            'probability' => '中奖概率(‱)'
        ];
    }

    public function rules()
    {
        return [
            [['act_id', 'name', 'content', 'num', 'probability', 'num_show'], 'required'],
            [['id', 'act_id', 'num', 'probability', 'num_show', 'bonus_amount', 'bonus_random', 'max_amount', 'min_amount'], 'integer'],
            [['name'], 'string'],
            [['probability'], 'integer', 'max' => 10000],
        ];
    }

    public function beforeSave($insert = NULL)
    {
        $this->max_amount = $this->max_amount ? $this->max_amount : 0;
        $this->min_amount = $this->min_amount ? $this->min_amount : 0;
        return true;
    }

}
