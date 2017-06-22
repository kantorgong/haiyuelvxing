<?php
/**
 * 自定义变量模型
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/10/12 16:15
 * @since    1.0
 */

namespace common\models;

use Yii;
use components\helper\CacheUtility;
class Sysvariable extends \components\db\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_variable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'data_type', 'is_cache', 'value'], 'required'],
            [['id'], 'unique'],
            [['value'], 'string'],
            [['data_type', 'is_cache'], 'integer'],
            [['id', 'name'], 'string', 'max' => 64],
            [['note'], 'string', 'max' => 256],
            [['id'], 'unique']
        ];
    }

    public function checkExist()
    {
        if ($this->isNewRecord || $this->id != $this->oldAttributes['id'])
        {
            $ret = Sysvariable::findOne($this->id);
            return $ret !== null;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '变量名',
            'name' => '标示',
            'value' => '变量值',
            'data_type' => '数据类型',
            'note' => '描述',
            'is_cache' => '开启缓存',
        ];
    }

    public function afterSave($insert = Null, $changedAttributes = NULL)
    {
        //刷新缓存
        CacheUtility::createVariableCache();
    }
}
