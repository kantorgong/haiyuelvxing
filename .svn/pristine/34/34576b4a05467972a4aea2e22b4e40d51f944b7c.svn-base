<?php

namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "ticket_venue".
 *
 * @property integer $venue_id
 * @property string $name
 * @property string $phone
 * @property string $start_time
 * @property string $end_time
 * @property string $address
 * @property double $coordinate_x
 * @property double $coordinate_y
 * @property string $detail_desc
 * @property integer $insert_id
 * @property integer $insert_time
 * @property integer $modify_id
 */
class TicketVenue extends \yii\db\ActiveRecord
{
    public $coordinate;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_venue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'start_time', 'end_time', 'address', 'coordinate_x', 'coordinate_y'], 'required'],
            [['coordinate_x', 'coordinate_y'], 'number'],
            [['detail_desc'], 'string'],
            [['insert_id', 'insert_time', 'modify_id'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 32],
            [['start_time', 'end_time'], 'string', 'max' => 18],
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->insert_time = time();
            $this->insert_id = \Yii::$app->user->id;
        }
        else
        {
            $this->modify_id = \Yii::$app->user->id;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'venue_id' => '场馆编号',
            'name' => '场馆名称',
            'phone' => '电话',
            'start_time' => '开始营业时间',
            'end_time' => '结束营业时间',
            'address' => '场馆详细地址',
            'coordinate_x' => 'Coordinate X',
            'coordinate_y' => 'Coordinate Y',
            'coordinate' => '详细坐标',
            'detail_desc' => '场馆介绍',
            'insert_id' => '添加人',
            'insert_time' => '添加时间',
            'modify_id' => '修改人',
        ];
    }
}
