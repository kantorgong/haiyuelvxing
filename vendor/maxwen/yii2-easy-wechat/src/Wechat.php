<?php
/**
 * Project: yii2-easyWeChat.
 * Author: Max.wen
 * Date: <2016/05/10 - 14:31>
 */

namespace maxwen\easywechat;

use yii;
use EasyWeChat\Foundation\Application;
use yii\base\Component;

/**
 * Class Wechat
 * @package common\components
 *
 * @property Application $app
 * @property WechatUser  $user
 * @property bool        $isWechat
 * @property string      $returnUrl
 */
class Wechat extends Component
{
	/**
	 * user identity class params
	 * @var array
	 */
	public $userOptions = [];
	/**
	 * wechat user info will be stored in session under this key
	 * @var string
	 */
	public $sessionParam = 'wxs_wechatUser_';
	/**
	 * returnUrl param stored in session
	 * @var string
	 */
	public $returnUrlParam = 'wxs_wechatReturnUrl_';
	/**
	 * @var Application
	 */
	private static $_app;
	/**
	 * @var WechatUser
	 */
	private static $_user;
    /**
     * @var array 配置参数
     */
    private $_config;

    /**
     * @Desc: 初始化配置文件
     */
    public function init()
    {
        //请求微信公众号
        $appAliasName = Yii::$app->session->get('wxs_wechatApp');
        if (!$appAliasName)
        {
            //非法请求，拒绝访问！
            throw new yii\web\NotFoundHttpException;
        }

        //微信公众号配置文件
        $configSessionName = 'wxs_wechatConfig_' . $appAliasName;
        $jsonConfig = Yii::$app->session->get($configSessionName);
        if (!$jsonConfig)
        {
            //设置配置文件
            $jsonConfig = Yii::$app->redis->get('wx_apps:' . $appAliasName); //redis统一KEY命名方式为表名:key
            if (!$jsonConfig)
            {
                //非法请求，拒绝访问！
                throw new yii\web\NotFoundHttpException;
            }
            Yii::$app->session->set($configSessionName, $jsonConfig);
        }
        $this->_config = \GuzzleHttp\json_decode($jsonConfig, true);

        //是否静默授权
        if (Yii::$app->session->has('wxs_wechatSilence_' . $appAliasName))
        {
            $this->_config['oauth']['scopes'] = ['snsapi_base'];
        }

        parent::init();
    }

    /**
	 * @return yii\web\Response
	 */
	public function authorizeRequired($setReturnUrl='')
	{
        if(Yii::$app->request->get('code')) {
			// callback and authorize
			return $this->authorize($this->app->oauth->user());
		}else{
			// redirect to wechat authorize page
            $this->setReturnUrl($setReturnUrl ?:Yii::$app->request->getUrl());
			return Yii::$app->response->redirect($this->app->oauth->redirect()->getTargetUrl());
		}
	}
	
	/**
	 * @param \Overtrue\Socialite\User $user
	 * @return yii\web\Response
	 */
	public function authorize(\Overtrue\Socialite\User $user)
	{
		Yii::$app->session->set($this->sessionParam, $user->toJSON());
		return Yii::$app->response->redirect($this->getReturnUrl());
	}

	/**
	 * check if current user authorized
	 * @return bool
	 */
	public function isAuthorized()
	{
        $hasSession = Yii::$app->session->has($this->sessionParam);
		$sessionVal = Yii::$app->session->get($this->sessionParam);
		return ($hasSession && !empty($sessionVal));
	}

	/**
	 * @param string|array $url
	 */
	public function setReturnUrl($url)
	{
		Yii::$app->session->set($this->returnUrlParam, $url);
	}

	/**
	 * @param null $defaultUrl
	 * @return mixed|null|string
	 */
	public function getReturnUrl($defaultUrl = null)
	{
		$url = Yii::$app->getSession()->get($this->returnUrlParam, $defaultUrl);
		if (is_array($url)) {
			if (isset($url[0])) {
				return Yii::$app->getUrlManager()->createUrl($url);
			} else {
				$url = null;
			}
		}

		return $url === null ? Yii::$app->getHomeUrl() : $url;
	}

	/**
	 * single instance of EasyWeChat\Foundation\Application
	 * @return Application
	 */
	public function getApp()
	{
		if(! self::$_app instanceof Application){
			self::$_app = new Application($this->_config);
		}
		return self::$_app;
	}

	/**
	 * @return WechatUser|null
	 */
	public function getUser()
	{
		if(!$this->isAuthorized()) {
			return new WechatUser();
		}

		if(! self::$_user instanceof WechatUser) {
			$userInfo = Yii::$app->session->get($this->sessionParam);
			$config = $userInfo ? json_decode($userInfo, true) : [];
			self::$_user = new WechatUser($config);
		}
		return self::$_user;
	}

	/**
	 * overwrite the getter in order to be compatible with this component
	 * @param $name
	 * @return mixed
	 * @throws \Exception
	 */
	public function __get($name)
	{
		try {
			return parent::__get($name);
		}catch (\Exception $e) {
			if($this->getApp()->$name) {
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