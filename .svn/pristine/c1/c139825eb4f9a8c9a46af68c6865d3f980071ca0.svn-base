<?php

namespace common\models\wxservice;

use Yii;
use components\helper\CommonUtility;

/**
 * This is the model class for table "users".
 *
 * @property integer $uid
 * @property string $guid
 * @property string $open_id
 * @property string $nickname
 * @property integer $sex
 * @property string $province
 * @property string $city
 * @property string $country
 * @property string $headimgurl
 * @property string $union_id
 * @property integer $insert_time
 * @property integer $modify_time
 */
class Users extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'insert_time', 'modify_time'], 'integer'],
            [['guid'], 'string', 'max' => 64],
            [['open_id', 'union_id'], 'string', 'max' => 128],
            [['nickname', 'province', 'city', 'country'], 'string', 'max' => 30],
            [['headimgurl'], 'string', 'max' => 500],
            [['open_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '编号',
            'open_id' => '微信编号',
            'nickname' => '昵称',
            'sex' => '性别',
            'province' => '省份',
            'city' => '城市',
            'country' => 'Country',
            'headimgurl' => 'Headimgurl',
            'union_id' => 'Union ID',
            'insert_time' => '添加时间',
            'modify_time' => 'Modify Time',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->insert_time = time();
            $this->modify_time = 0;
        }
        else
        {
            $this->modify_time = time();
        }
        return true;
    }
}
