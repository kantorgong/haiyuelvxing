<?php

namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "love_user".
 *
 * @property integer $uid
 * @property string $open_id
 * @property string $nickname
 * @property string $phone
 * @property string $wechat
 * @property string $address
 * @property string $sex
 * @property string $orientation
 * @property string $birth
 * @property string $constellation
 * @property string $hobby
 * @property string $mark
 * @property string $description
 * @property string $photo
 * @property integer $active_time
 * @property integer $mate_uid
 * @property integer $insert_time
 */
class LoveUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'love_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mate_uid'], 'integer'],
            [['open_id'], 'string', 'max' => 128],
            [['nickname', 'orientation', 'constellation'], 'string', 'max' => 30],
            [['phone', 'wechat', 'birth'], 'string', 'max' => 50],
            [['address', 'hobby'], 'string', 'max' => 200],
            [['sex'], 'string', 'max' => 10],
            [['mark', 'photo'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['active_time', 'insert_time', 'start_time', 'leave', 'modify_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'ID',
            'open_id' => 'Open ID',
            'nickname' => '姓名',
            'phone' => '电话',
            'wechat' => '微信号',
            'address' => '所在地',
            'sex' => '性别',
            'orientation' => '性取向',
            'birth' => '出生年月',
            'constellation' => '星座',
            'hobby' => '爱好',
            'mark' => '标签',
            'description' => '自我介绍',
            'photo' => 'Photo',
            'active_time' => 'Active Time',
            'mate_uid' => '配对ID',
            'insert_time' => 'Insert Time',
        ];
    }

    public function beforeSave($insert = NULL)
    {
        if($this->isNewRecord)
        {
            $this->insert_time = time();
        }
        else
        {
            $this->modify_time = time();
        }
        return true;
    }
}
