<?php

namespace common\models\activity;

use Yii;

/**
 * This is the model class for table "scratch_user_info".
 *
 * @property integer $id
 * @property string $open_id
 * @property string $name
 * @property string $nickname
 * @property string $avatar
 * @property string $email
 * @property integer $sex
 * @property string $language
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $unionid
 */
class ScratchUserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scratch_user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex'], 'integer'],
            [['open_id', 'name', 'nickname', 'email', 'unionid'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 256],
            [['language', 'city', 'province', 'country'], 'string', 'max' => 32],
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
            'name' => 'Name',
            'nickname' => 'Nickname',
            'avatar' => 'Avatar',
            'email' => 'Email',
            'sex' => 'Sex',
            'language' => 'Language',
            'city' => 'City',
            'province' => 'Province',
            'country' => 'Country',
            'unionid' => 'Unionid',
        ];
    }
}
