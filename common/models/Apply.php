<?php

/**
 * @filename Apply.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 16:02:50
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use components\db\BaseActiveRecord;
use yii\behaviors\BlameableBehavior;

class Apply extends BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_apply';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'guid' => 'GUID',
            'mp_type' => '授权公众号',
            'title' => '标题',
            'summary' => '简介',
            'start_time' => '开始报名时间',
            'end_time' => '报名截止时间',
            'forms' => '表单',
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
            [['title', 'summary', 'start_time', 'end_time', 'forms', 'is_use', 'mp_type'], 'required'],
            [['insert_id', 'modify_id', 'is_use'], 'integer'],
            [['title', 'summary', 'forms', 'guid'], 'string'],
            [['forms'], 'string'],
            [['title', 'summary'], 'string', 'max' => 255],
        ];
    }
}

?>