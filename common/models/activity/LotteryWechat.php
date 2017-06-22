<?php

namespace common\models\activity;

use Yii;
use yii\db\ActiveRecord;

class LotteryWechat extends ActiveRecord
{

    public static function tableName()
    {
        return 'lottery_wechat';
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '编号'),
            'openid' => Yii::t('app', '微信OPENID'),
            'nickname' => Yii::t('app', '昵称'),
            'sex' => Yii::t('app', '性别'),
            'city' => Yii::t('app', '城市'),
            'country' => Yii::t('app', '国家'),
            'province' => Yii::t('app', '省份'),
            'language' => Yii::t('app', '语言'),
            'headimgurl' => Yii::t('app', '头像'),
            'insert_time' => Yii::t('app', '添加时间'),
        ];
    }

    public function rules()
    {
        return [
            [['openid'], 'required'],
            [['id', 'sex', 'insert_time'], 'integer'],
            [['openid', 'nickname', 'city', 'country', 'province', 'headimgurl', 'unionid'], 'string'],
        ];
    }

}
