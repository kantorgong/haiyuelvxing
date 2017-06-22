<?php

/**
 * 微信服务用户表
 */
namespace common\models\wxplus;

use Yii;
use components\db\BaseActiveRecord;

class WxsUser extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wxs_user';
    }

    public function attributeLabels()
    {
        return [
                'uid' => 'ID',
                'open_id' => '微信ID',
                'nickname' => '昵称',
                'sex' => '性别',
                'province' => '省份',
                'city' => '城市',
                'country' => '国家',
                'from' => '来源公众号',
                'insert_time' => '添加时间'
        ];
    }

    public function rules()
    {
        return [
            [['open_id'], 'required'],
            [['insert_time', 'uid', 'sex'], 'integer'],
            [['nickname', 'province', 'city', 'country', 'headimgurl', 'union_id', 'from'], 'string'],
        ];
    }
}

?>