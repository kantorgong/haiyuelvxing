<?php

namespace backend\modules\admin\models;

use Yii;
use yii\base;
use yii\web\IdentityInterface;
use yii\helpers;
use yii\base\Security;
use components\helper\Regexp;
use components\helper\StringHelper;
use backend\modules\admin\ModuleAdmin;
use yii\db\ActiveRecord;

class User extends \backend\modules\admin\components\ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 0;
    const AUTH_KEY = 'xyadmin';
    public $accessToken;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username,name,email'], 'filter', 'filter' => 'trim'],

            [['username'], 'required', 'message' => '用户名不能为空'],
//            [['dpt_id'], 'required', 'message' => '请选择部门'],
            [['name'], 'required', 'message' => '姓名不能为空'],
            [['email'], 'email', 'message' => '邮件格式不对'],
//            [['password'], 'required', 'message' => '密码不能为空'],
//            [['role_id'], 'required', 'message' => '角色不能为空'],
            [['role_id', 'status', 'created_at', 'updated_at', 'dpt_id', 'lastlogin_at'], 'integer'],
            [['setting'], 'string', 'message' => '设置'],
            [['name'], 'string', 'max' => 30, 'message' => '姓名超过30个字符'],
            [['username'], 'string', 'max' => 15, 'min' => 3, 'tooLong' => '用户名大于15个字符', 'tooShort' => '用户名小于3个字符'],
            [['password'], 'string', 'max' => 40, 'min' => 6, 'tooLong' => '密码大于40个字符', 'tooShort' => '密码小于6个字符'],
//            [['encrypt'], 'string', 'max' => 6],
            [['username'], 'unique', 'message' => '用户名已被占用'],
            [['username'], 'match', 'pattern' => Regexp::$username, 'message' => '用户名格式不正确'],

            ['password', 'required', 'on' => 'default']
        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['username', 'password', 'name', 'encrypt', 'email', 'status', 'setting'],
            'update' => ['username', 'password', 'name', 'encrypt',  'email', 'status', 'setting'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'password' => '密码',
            'name' => '姓名',
            'email' => '邮箱',
            'encrypt' => '加密',
            'dpt_id' => '部门',
            'role_id' => '角色',
            'status' => '禁用',
            'setting' => '设置',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'lastlogin_at' => '最后登录时间',
            'lastlogin_ip' => '最后登录ip',
        ];
    }

    /***************  数据关系 ***************/
    /**
     * 获取角色
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * 获取用户和部门信息
     */
    public function findUserInfo($offset,$limit,$count=false)
    {
        $data = array();
        if ($count)
        {
            $sql = "SELECT count(u.id) as total FROM `admin_user` as u LEFT JOIN `admin_role` as r ON u.role_id = r.id";
            $countNum = Yii::$app->db->createCommand($sql)->queryOne();
            $data['total'] = $countNum['total'];
        }
        $sql = "SELECT u.id,u.username,u.name,u.status,u.created_at,u.updated_at,r.name as rname FROM `admin_user` as u LEFT JOIN `admin_role` as r ON u.role_id = r.id LIMIT $offset,$limit";
        // 绑定参数查询
        /*        $sql = "SELECT u.id,u.username,u.name,u.status,u.created_at,u.updated_at,r.name as rname FROM `admin_user` as u LEFT JOIN `admin_role` as r ON u.role_id = r.id WHERE u.id=:id";
                $data = array(':id'=>35);*/
        $data['info'] = Yii::$app->db->createCommand($sql)->bindValues($data)->queryAll();
        return $data;
    }

    /**
     * 获取全部用户
     */
    public function findAllUserInfo()
    {
        $data = array();
        $sql = "SELECT `id`,`name` FROM `admin_user` where status = 0";
        return Yii::$app->db->createCommand($sql)->bindValues($data)->queryAll();
    }

    //获取部门
    public  function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'dpt_id']);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->encrypt = StringHelper::random(6);
        }
        if ($this->getScenario() === 'update' && $this->password == '')
        {
            $this->rules();
        }
        return parent::beforeValidate();
    }

    /**
     * 保存前
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) return false;
        if ($this->isNewRecord)
        {
            $this->password = self::hashPassword($this->password, $this->encrypt);
        }
        else
        {
            if ($this->getScenario() === 'update')
            {
                if (!empty($this->password))
                {
                    $this->encrypt = StringHelper::random(6);
                    $this->password = self::hashPassword($this->password, $this->encrypt);
                }
                else
                {
                    $this->password = $this->oldAttributes['password'];
                }
            }

        }
        return true;
    }

    /**
     *
     * @param string $password 明文密码
     * @return string 加密后
     */
    public static function hashPassword($password, $encrypt)
    {
        return md5(md5($password) . $encrypt);
    }

    /*************** 用户登陆 **********************/
    /**
     * 获取用户ID
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * 获取用户
     * @param int|string $id
     * @return User
     */
    public static function findIdentity($id)
    {
        $model = self::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
        return $model;
    }

    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        $id = \yii\helpers\Security::decrypt($token, self::AUTH_KEY);

        return static::findOne(['id' => $id, 'status' => [
            static::STATUS_ACTIVE
        ]]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return self
     */
    public static function findByUsername($username)
    {
        $file = 'username';

        return static::findOne([$file => $username, 'status' => [
            static::STATUS_ACTIVE
        ]]);
//        return static::findBySql('SELECT * FROM '.self::tableName().' WHERE status = :status and   username =:username  ', [':username' => $username,  ':status' => static::STATUS_ACTIVE])->one();
    }

    /**
     * 获取
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return \yii\helpers\Security::decrypt($this->id, static::AUTH_KEY);
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 验证密码
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password == self::hashPassword($password, $this->encrypt);
    }

}
