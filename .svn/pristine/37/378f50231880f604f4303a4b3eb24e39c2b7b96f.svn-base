<?php
/**
 * 错误日志模型类
 */

namespace backend\modules\admin\models;

use backend\modules\admin\ModuleAdmin;
use yii\db\ActiveRecord;

class ErrorLog extends \backend\modules\admin\components\ActiveRecord
{
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'log';
    }

    public function rules()
    {
        return [
            [['level', 'category' ,'log_time', 'prefix', 'message'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'level' => '错误级别',
            'category' => '类别',
            'log_time' => '记录时间',
            'prefix' => '前缀内容',
            'message' => '错误内容'
        ];
    }
}