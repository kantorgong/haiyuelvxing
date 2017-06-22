<?php

namespace common\models\wxservice;

use Yii;

/**
 * This is the model class for table "custom_extend".
 *
 * @property integer $kid
 * @property string $name
 * @property integer $status
 * @property integer $insert_time
 * @property integer $modify_time
 * @property integer $insert_id
 * @property integer $modify_id
 */
class CustomExtend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_extend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status', 'insert_time', 'modify_time', 'insert_id', 'modify_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->insert_time = time();
            $this->modify_time = 0;
            $this->insert_id = Yii::$app->getUser()->id;
            $this->modify_id = 0;
        }
        else
        {
            $this->modify_time = time();
            $this->modify_id = Yii::$app->getUser()->id;
        }
        return true;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kid' => '扩展编号',
            'name' => '扩展名称',
            'status' => '扩展状态',
            'insert_time' => '添加时间',
            'modify_time' => '修改时间',
            'insert_id' => '添加人',
            'modify_id' => '修改人',
        ];
    }
}
