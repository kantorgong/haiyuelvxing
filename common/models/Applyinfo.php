<?php

/**
 * @filename Applyinfo.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 16:03:26
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use components\db\BaseActiveRecord;
use yii\behaviors\BlameableBehavior;

class Applyinfo extends BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_apply_infos';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'apply_id' => '报名活动编号',
            'ip' => Yii::t('app', 'IP'),
            'info_values' => '报名信息',
            'insert_time' => '添加时间',
            'openid' => '微信唯一标识',
            'nickname' => '微信昵称',
        ];
    }

    public function rules()
    {
        return [
            [['apply_id', 'ip', 'info_values'], 'required'],
            [['apply_id', 'insert_time'], 'integer'],
            [['info_values', 'openid', 'nickname'], 'string'],
        ];
    }

}

?>