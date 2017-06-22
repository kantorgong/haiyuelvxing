<?php
/**
 * 日志
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2016/1/14 0014 17:25
 * @since    1.0
 */

namespace backend\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

class Log extends \yii\mongodb\ActiveRecord
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
        return 'xylog';
    }

    /**
     * @return
     */
    public function attributes()
    {
        return ['_id', 'userid', 'username', 'created_at', 'updated_at', 'ip', 'title', 'module', 'controller', 'action', 'url', 'depict'];
    }

    public function rules()
    {
        return [
            [['username', 'ip' ,'url'], 'required']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => '编号',
            'userid' => '用户编号',
            'username' => '用户名',
            'title' => '标题',
            'created_at' => '添加时间',
            'updated_at' => '添加时间',
            'module' => '模块',
            'ip' => 'IP',
            'depict' => '描述',
            'url' => 'url',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return (string)$this->_id;
    }


}