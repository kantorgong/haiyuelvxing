<?php

namespace common\models\activity;

use Yii;

/**
 * This is the model class for table "scratch_card_prize".
 *
 * @property integer $log_id
 * @property string $open_id
 * @property string $money
 * @property string $ip
 * @property string $date
 * @property integer $status
 * @property string $return_log
 * @property string $insert_time
 * @property string $send_time
 */
class ScratchCardPrize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scratch_card_prize';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['open_id', 'money', 'ip', 'date', 'status'], 'required'],
            [['money'], 'number'],
            [['status'], 'integer'],
            [['return_log'], 'string'],
            [['insert_time', 'send_time'], 'safe'],
            [['open_id'], 'string', 'max' => 64],
            [['ip'], 'string', 'max' => 32],
            [['date'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'open_id' => 'Open ID',
            'money' => 'Money',
            'ip' => 'Ip',
            'date' => 'Date',
            'status' => 'Status',
            'return_log' => 'Return Log',
            'insert_time' => 'Insert Time',
            'send_time' => 'Send Time',
        ];
    }
}
