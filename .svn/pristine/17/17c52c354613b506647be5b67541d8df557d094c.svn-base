<?php

namespace common\models\wxservice;

use Yii;

/**
 * This is the model class for table "custom_user".
 *
 * @property integer $uid
 * @property string $nick_name
 * @property string $user_name
 * @property string $passwd
 * @property integer $user_group
 * @property integer $status
 * @property integer $insert_time
 * @property integer $modify_time
 * @property integer $insert_id
 * @property integer $modify_id
 */
class CustomUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name',], 'required'],
            [['user_group', 'status', 'insert_time', 'modify_time', 'insert_id', 'modify_id'], 'integer'],
            ['user_name', 'unique','message'=>'登录账号已存在'],
            [['nick_name', 'user_name', 'passwd'], 'string', 'max' => 64],
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->insert_time = time();
            $this->modify_time = 0;
            $this->insert_id = Yii::$app->getUser()->id;
            $this->modify_id = 0;
            $this->passwd = empty($this->passwd) ? md5(123456) : md5($this->passwd);
        }
        else
        {
            $this->modify_time = time();
            $this->modify_id = Yii::$app->getUser()->id;
            if($this->passwd) $this->passwd = md5($this->passwd);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户编号',
            'nick_name' => '昵称',
            'user_name' => '登录账号',
            'passwd' => '密码',
            'user_group' => '用户所属组',
            'status' => '状态',
            'insert_time' => '添加时间',
            'modify_time' => '修改时间',
            'insert_id' => '添加人',
            'modify_id' => '修改人',
        ];
    }
}
