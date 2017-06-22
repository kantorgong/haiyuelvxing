<?php

namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "ticket_activity".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $pic
 * @property integer $venue_id
 * @property integer $start_time
 * @property string $date
 * @property integer $week
 * @property integer $enroll_num
 * @property string $enroll_form
 * @property string $price
 * @property string $detail
 * @property integer $insert_id
 * @property integer $insert_time
 * @property integer $modify_id
 */
class TicketActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'pic', 'venue_id', 'start_time', 'date', 'week', 'enroll_num', 'enroll_form', 'price', 'detail', 'insert_id', 'insert_time'], 'required'],
            [['type', 'venue_id', 'start_time', 'week', 'enroll_num', 'insert_id', 'insert_time', 'modify_id'], 'integer'],
            [['date'], 'safe'],
            [['enroll_form', 'detail'], 'string'],
            [['title', 'pic', 'price'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'title' => '标题',
            'type' => '类型',
            'pic' => '图片',
            'venue_id' => '场馆',
            'start_time' => '开始时间',
            'date' => 'Date',
            'week' => 'Week',
            'enroll_num' => '报名人数',
            'enroll_form' => 'Enroll Form',
            'price' => 'Price',
            'detail' => 'Detail',
            'insert_id' => '添加人',
            'insert_time' => '添加时间',
            'modify_id' => '修改人',
        ];
    }
}
