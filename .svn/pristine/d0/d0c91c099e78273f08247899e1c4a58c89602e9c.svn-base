<?php
/**
 * 名称
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/16 17:15
 * @since    1.0
 */

namespace backend\modules\admin\form;

use Yii;
use yii\base\Model;
use backend\modules\admin\models\User;
use yii\log\Logger;
use  yii\web\Session;
class LoginForm extends Model
{
    public $username;
    public $password;
//    public $rememberMe = true;
    public $verifyCode;


    private $_user = false;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required', 'message' => '用户名不能为空'],
            [['password'], 'required', 'message' => '密码不能为空'],
            ['password', 'validatePassword'],
//            ['rememberMe', 'boolean'],
            ['verifyCode', 'captcha', 'captchaAction' => '/admin/default/captcha', 'message' => '验证码错误'],
        ];
    }

    /**
     * 验证密码
     *
     */
    public function validatePassword()
    {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password))
        {
            $this->addError('password', '帐号或者密码错误');
        }
    }

    /**
     * 登录
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
        {
            //写日志
            self::do_login_log();
            //登录成功 记住密码用户 保留一个月登录信息
            return Yii::$app->user->login($this->getUser());
        }
        else
        {
            return false;
        }
    }

    //写日志
    public function do_login_log()
    {
        if($this->getUser()->getId() > 0)
        {
            $data = User::findIdentity($this->getUser()->getId());
            //获取上次登录时间、ip
            $session = yii::$app->session;
            $session->set('lastlogin_at', $data->lastlogin_at);
            $session->set('lastlogin_ip', $data->lastlogin_ip);
            //更新本次登录时间、ip
            $data->lastlogin_at = time();
            $data->lastlogin_ip = Yii::$app->getRequest()->getUserIP();
            $data->save();
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    private function getUser()
    {
        if ($this->_user === false)
        {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}