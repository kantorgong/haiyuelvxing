<?php

namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "chat_log".
 *
 * @property integer $chat_id
 * @property integer $senderid
 * @property integer $receiverid
 * @property integer $send_time
 * @property string $content
 * @property integer $msg_type
 * @property integer $is_read
 * @property integer $is_del
 * @property string $talk_id
 */
class ChatLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'love_chat_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['senderid', 'receiverid', 'send_time', 'content', 'talk_id'], 'required'],
            [['senderid', 'receiverid', 'send_time', 'msg_type', 'is_read', 'is_del'], 'integer'],
            [['content'], 'string'],
            [['talk_id'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'senderid' => 'Senderid',
            'receiverid' => 'Receiverid',
            'send_time' => 'Send Time',
            'content' => 'Content',
            'msg_type' => 'Msg Type',
            'is_read' => 'Is Read',
            'is_del' => 'Is Del',
            'talk_id' => 'Talk ID',
        ];
    }
}
