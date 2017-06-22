<?php

namespace common\models\wxservice;

use Yii;

/**
 * This is the model class for table "custom_apps_extend".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $kid
 */
class CustomAppsExtend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_apps_extend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'kid'], 'required'],
            [['pid', 'kid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'kid' => 'Kid',
        ];
    }
}
