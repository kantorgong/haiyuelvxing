<?php
/**
 * @filename TopLine.php
 * @encoding UTF-8
 * @author tianxq
 * @copyright xxcb
 * @license xxcb
 * @datetime 2017-1-13 17:02:50
 * @version 1.0
 * @Description 官网头版头条模型类
 * @copyright (c) 2017-1-13, 潇湘晨报（版权）
 * @access public 权限
 */
namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "ticket_activity".
 *
 * @property integer $id
 * @property string $guid
 * @property string $t_name
 * @property string $keywords
 * @property string $t_note
 * @property string $t_pic
 * @property integer $insert_time
 */
class TopLine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xxcb_top_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_name'], 'required'],
            [['insert_time'], 'integer'],
            [['t_note'], 'safe'],
            [['guid', 't_name', 'keywords', 't_pic'], 'string'],
            [['t_name', 'keywords'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'guid' => '头条guid',
            't_name' => '姓名',
            'keywords' => '关键字',
            't_note' => '头条说明',
            't_pic' => '头条图片',
            'insert_time' => '添加时间',
        ];
    }
}
