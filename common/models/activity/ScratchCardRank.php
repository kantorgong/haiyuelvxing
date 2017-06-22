<?php

namespace common\models\activity;

use Yii;

/**
 * This is the model class for table "scratch_card_rank".
 *
 * @property integer $id
 * @property string $open_id
 * @property integer $score
 * @property integer $mtime
 * @property string $date
 * @property string $ip
 * @property string $modify_time
 */
class ScratchCardRank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scratch_card_rank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['open_id', 'score', 'mtime', 'date', 'ip'], 'required'],
            [['score', 'mtime'], 'integer'],
            [['modify_time'], 'safe'],
            [['open_id'], 'string', 'max' => 64],
            [['date'], 'string', 'max' => 12],
            [['ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'open_id' => 'Open ID',
            'score' => 'Score',
            'mtime' => 'Mtime',
            'date' => 'Date',
            'ip' => 'Ip',
            'modify_time' => 'Modify Time',
        ];
    }
}
