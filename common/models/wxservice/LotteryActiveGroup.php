<?php

namespace common\models\wxservice;

use Yii;
use backend\modules\admin\models\User;

class LotteryActiveGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lottery_active_group';
    }

    public function rules()
    {
        return [
            [['group_id', 'title', 'depict'], 'string'],
            [['title'], 'required'],
            [['insert_time', 'insert_id', 'modify_time', 'modify_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'group_id' => '编号',
            'title' => '活动分组',
            'depict' => '描述',
            'insert_time' => '添加时间',
            'insert_id' => '添加人',
            'modify_time' => '更新时间',
            'modify_id' => '修改人',
        ];
    }


    public function beforeSave($insert = NULL)
    {
        if ($this->isNewRecord)
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

    public function getInsertor()
    {
        return $this->hasOne(User::className(), ['id' => 'insert_id'])->select('name');
    }

    public function getModifior()
    {
        return $this->hasOne(User::className(), ['id' => 'modify_id'])->select('name');
    }

    public static function groupList()
    {
        $list = self::find()->asArray()->all();
        if (!$list) return [];
        $return = [];
        foreach ($list as $value)
        {
            $return[$value['group_id']] = $value['title'];
        }
        return $return;
    }
}