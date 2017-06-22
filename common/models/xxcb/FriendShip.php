<?php

namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "friend_ship".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $fid
 * @property string $talk_id
 * @property integer $status
 */
class FriendShip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'love_friend_ship';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'fid', 'talk_id'], 'required'],
            [['uid', 'fid', 'status'], 'integer'],
            [['talk_id'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'fid' => 'Fid',
            'talk_id' => 'Talk ID',
            'status' => 'Status',
        ];
    }
}
