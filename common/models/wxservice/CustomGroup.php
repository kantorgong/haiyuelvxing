<?php

namespace common\models\wxservice;

use Yii;

/**
 * This is the model class for table "custom_group".
 *
 * @property integer $group_id
 * @property string $name
 * @property string $insert_time
 * @property string $modify_time
 */
class CustomGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'insert_time', 'modify_time'], 'required'],
            [['insert_time', 'modify_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'name' => 'Name',
            'insert_time' => 'Insert Time',
            'modify_time' => 'Modify Time',
        ];
    }
}
