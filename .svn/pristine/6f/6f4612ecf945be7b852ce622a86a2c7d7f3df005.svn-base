<?php
namespace components\wechat;

use yii;
use EasyWeChat\Foundation\Application;
use yii\base\Component;
use common\models\redis\WxsUser;

/**
 * Class Wechat
 * @package common\components
 *
 * @property Application $app
 * @property WechatUser  $user
 * @property bool        $isWechat
 * @property string      $returnUrl
 * @property array       $config
 */
class Wechat extends Component
{
    /**
     * @var Application
     */
    private static $_app;

    /**
     * @var WechatUser
     */
    private static $_user;


    /**
     * @Desc: 初始化方法
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function init()
    {
        parent::init();

        /**
         * 只允许微信内访问
         */
        if (!$this->isWechat)
        {
            header("content-type:text/html;charset=utf8");
            echo '<p style="margin-top:120px;font-size:20px;font-weight:bold;">请在微信内打开本页面</p>';
            exit();
        }
    }

    /**
     * @return yii\web\Response
     */
    public function authorizeRequired()
    {
        if (Yii::$app->request->get('code'))
        {
            $this->authorize($this->getApp()->oauth->user());
        }
        else
        {
            //如果COOKIE已存在，拒绝重复请求，如果没有来源，拒绝请求！
            $returnUrl = Yii::$app->request->get('returnUrl');
            if (!$returnUrl)
                throw new yii\web\NotFoundHttpException();

            Yii::$app->session->set('wxs_appName', Yii::$app->request->get('appName', 'xxcb'));     # 微信回调时使用
            Yii::$app->session->set('wxs_returnUrl', Yii::$app->request->get('returnUrl'));         # 返回来源页使用
            $snsApi = Yii::$app->request->get('snsApi', 'snsapi_userinfo');
            Yii::$app->session->set('wxs_snsApi', $snsApi); # 接口方式
            $this->getApp()->oauth->scopes([$snsApi])->redirect()->send();
        }
    }

    /**
     * @param \Overtrue\Socialite\User $user
     * @return yii\web\Response
     */
    public function authorize(\Overtrue\Socialite\User $user)
    {
        //将数据更新到数据库
        //$this->_saveUserData($user);

        //将数据更新到COOKIE中。域名设置成顶级域名。加上appName用以区分可能出现的冲突问题。区分静默授权和获取用户信息
        $cookieName = 'wxs_openId_' . Yii::$app->session->get('wxs_appName');
        $cookieValue = $user['id'];
        Yii::$app->session->set('wxs_openId', $cookieValue);
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => $cookieName,
                'value' => $cookieValue,
                'expire' => time() + 8640000,
                'domain' => 'xxcb.' . \components\XyXy::getEnv(true)
        ]));

        if (Yii::$app->session->get('wxs_snsApi') == 'snsapi_userinfo')
        {
            $cookieName = 'wxs_userInfo_' . Yii::$app->session->get('wxs_appName');
            $cookieValue = $user->toJSON();
            Yii::$app->session->set('wxs_userInfo', $cookieValue);
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => $cookieName,
                    'value' => $cookieValue,
                    'expire' => time() + 8640000,
                    'domain' => 'xxcb.' . \components\XyXy::getEnv(true)
            ]));
        }

        Yii::$app->response->redirect(Yii::$app->session->get('wxs_returnUrl'))->send();
    }

    /**
     * @Desc: 保存微信用户信息到redis数据库
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $data
     */
    private function _saveUserData($data)
    {
        //判断数据库是否已经存在
        $model = new WxsUser();
        $user = $model->find()
                ->where(['open_id' => $data['id']])
                ->one();
        if (!$user)
        {
            $model->open_id = $data['id'];
            if ($data['nickname'])
            {
                $model->nickname = $data['nickname'];
                $model->sex = $data['original']['sex'];
                $model->province = $data['original']['province'];
                $model->country = $data['original']['country'];
                $model->headimgurl = $data['original']['headimgurl'];
                $model->union_id = isset($data['original']['union_id'])?$data['original']['union_id']:'';
                $model->city = $data['original']['city'];
            }
            $model->from = Yii::$app->session->get('wxs_appName');
            $model->insert_time = time();
            $model->save();
        }

        if ($user && !$user['nickname'] && $data['nickname'])
        {
            $user->nickname = $data['nickname'];
            $user->sex = $data['original']['sex'];
            $user->province = $data['original']['province'];
            $user->country = $data['original']['country'];
            $user->headimgurl = $data['original']['headimgurl'];
            $user->union_id = isset($data['original']['union_id'])?:'';
            $user->city = $data['original']['city'];
            $user->save();
        }
    }

    /**
     * @return Application
     */
    public function getApp()
    {
        if(!self::$_app instanceof Application)
        {
            self::$_app = new Application(Yii::$app->params['wechat'][Yii::$app->session->get('wxs_appName')]);
        }
        return self::$_app;
    }

    /**
     * @return WechatUser|null
     */
    public function getUser()
    {
        if(!$this->isAuthorized())
        {
            return new WechatUser();
        }

        if(!self::$_user instanceof WechatUser)
        {
            $userInfo = Yii::$app->session->get($this->sessionParam);
            $config = $userInfo ? json_decode($userInfo, true) : [];
            self::$_user = new WechatUser($config);
        }
        return self::$_user;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        }catch (\Exception $e) {
            if($this->app->$name) {
                return $this->app->$name;
            }else{
                throw $e->getPrevious();
            }
        }
    }

    /**
     * check if client is wechat
     * @return bool
     */
    public function getIsWechat()
    {
        return strpos($_SERVER["HTTP_USER_AGENT"], "MicroMessenger") !== false;
    }
}