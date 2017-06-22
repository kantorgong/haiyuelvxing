<?php

/**
 * @filename Applyoption.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 16:03:42
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use components\db\BaseActiveRecord;
use yii\behaviors\BlameableBehavior;

class Applyoption extends BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_apply_option';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'info_title' => '字段标题',
            'info_name' => 'html标签name属性',
            'info_label' => 'html标签',
            'info_type' => 'html标签type属性',
            'options' => '选项',
            'is_use' => '是否使用',
            'modify_id' => '修改人编号',
            'modify_time' => '修改时间',
            'insert_time' => '添加时间',
            'insert_id' => '添加人编号',
        ];
    }

    public function rules()
    {
        return [
            [['info_name', 'info_label', 'is_use', 'info_title'], 'required'],
            [['is_use', 'modify_time', 'insert_time', 'insert_id', 'modify_id'], 'integer'],
            [['info_name', 'info_label', 'info_type','options', 'info_title'], 'string'],
        ];
    }

}

?>