<?php
/**
 * @filename BaseController.php
 * @encoding UTF-8
 * @author tianxq
 * @copyright xxcb
 * @license xxcb
 * @datetime 2017-1-13 17:02:50
 * @version 1.0
 * @Description 官网头版头条敏感词汇模型类
 * @copyright (c) 2017-1-13, 潇湘晨报（版权）
 * @access public 权限
 */
namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "ticket_activity".
 *
 * @property integer $id
 * @property string $type
 * @property string $word
 */
class Sensitiveword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_sensitiveword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'word'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'type' => '类别',
            'word' => '敏感词',
        ];
    }
}
