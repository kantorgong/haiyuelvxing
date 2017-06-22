<?php

namespace common\models\activity;

use Yii;
use yii\db\ActiveRecord;

class LotteryRules extends ActiveRecord
{

    public static function tableName()
    {
        return 'lottery_rules';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'black' => '黑名单',
            'white' => '白名单',
            'behavior' => '行为时长(ms)',
            'refuse' => '主动拒绝(%)',
            'region' => '地区限制'
        ];
    }

    public function rules()
    {
        return [
            [['id', 'behavior', 'refuse'], 'integer'],
            [['black', 'white', 'region'], 'string'],
        ];
    }

    public function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->insert_id = Yii::$app->user->identity->id;
            $this->insert_time = time();
            $this->modify_time = 0;
        }
        else
        {
            $this->modify_id = Yii::$app->user->identity->id;
            $this->modify_time = time();
        }
        return true;
    }

}
