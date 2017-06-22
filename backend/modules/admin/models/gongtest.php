<?php


namespace backend\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

class Gongtest extends \yii\mongodb\ActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'gongtest';
    }

    /**
     * @return
     */
    public function attributes()
    {
        return ['id', 'name'];
    }

    public function rules()
    {
        return [
            [['id', 'name'], 'required']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'name' => '名称',
        ];
    }



    /**
     * @inheritdoc
     */
    public function getId()
    {
        return (string)$this->id;
    }


}