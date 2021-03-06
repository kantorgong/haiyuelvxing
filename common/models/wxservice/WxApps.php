<?php

namespace common\models\wxservice;

use Yii;
use backend\modules\admin\models\User;
use common\models\wxservice\CustomUser;

/**
 * This is the model class for table "wx_apps".
 *
 * @property integer $pid
 * @property string $app_name
 * @property string $alias_name
 * @property string $app_id
 * @property string $app_key
 * @property string $app_token
 * @property integer $app_type
 * @property integer $belong_user_id
 * @property integer $disabled
 * @property integer $insert_id
 * @property integer $insert_time
 * @property integer $modify_id
 * @property integer $modify_time
 */
class WxApps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_apps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_type', 'belong_user_id', 'disabled', 'insert_id', 'insert_time', 'modify_id', 'modify_time'], 'integer'],
            [['app_name', 'app_id', 'app_key', 'app_token', 'payment_merchant_id', 'payment_key'], 'string', 'max' => 128],
            [['alias_name'], 'string', 'max' => 30],
            [['alias_name'], 'unique'],
            [['app_name', 'app_id', 'app_key', 'alias_name', 'app_type'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => '编号',
            'app_name' => '名称',
            'alias_name' => '别名',
            'app_id' => 'app_id',
            'app_key' => 'app_key',
            'app_token' => 'app_token',
            'app_type' => '类别',
            'payment_merchant_id' => '支付商户号',
            'payment_key' => '支付密钥',
            'belong_user_id' => '所属用户',
            'disabled' => '禁用',
            'insert_id' => 'Insert ID',
            'insert_time' => 'Insert Time',
            'modify_id' => 'Modify ID',
            'modify_time' => 'Modify Time',
        ];
    }

    public function beforeSave($insert = NULL)
    {
        if($this->isNewRecord)
        {
            $this->insert_id = Yii::$app->user->identity->id;
            $this->insert_time = time();
            $this->modify_time = 0;
        }
        else
        {
            $this->modify_id = Yii::$app->user->identity->id;
            $this->modify_time = time();
        }
        return true;
    }

    public function getInsertor()
    {
        return $this->hasOne(User::className(),['id'=>'insert_id'])->select('name');
    }

    public function getModifior()
    {
        return $this->hasOne(User::className(),['id'=>'modify_id'])->select('name');
    }

    public function getBelongor()
    {
        return $this->hasOne(CustomUser::className(),['uid'=>'belong_user_id'])->select('user_name');
    }

    public static function appList()
    {
        $list = self::find()->where(['disabled' => 0])->asArray()->all();
        $ret = [];
        if ($list)
        {
            foreach ($list as $l)
            {
                $ret[$l['alias_name']] = $l['app_name'];
            }
        }
        return $ret;
    }
}
