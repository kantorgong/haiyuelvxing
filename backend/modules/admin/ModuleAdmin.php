<?php
/**
 * admin模块类
 *
 * 模块的配置、控制
 * @author   gongjt@xxcb.cn
 * @version  2015/9/17 14:00
 * @since    1.0
 */

namespace backend\modules\admin;


use Yii;
use yii\web\HttpException;
use backend\modules\admin\components\User;

class ModuleAdmin extends \yii\base\Module
{
    /**
     * 头像目录
     */
    const AVATAR_ROOT = '/upload/avatars/';
    public $controllerNamespace = 'backend\modules\admin\controllers';
    public $superUserIds = [];
    /**
     * 不需要登陆的页面
     * @var array
     */
    private $guestPages = [
        'admin/default/login',
        'admin/default/logout',
        'admin/default/error',
        //验证码
        'admin/default/captcha'
    ];

    /**
     * 公用页面
     * @param \yii\base\Action $action
     * @return bool
     */
    private $publicPages = [

    ];

    /**
     * 公用控制器
     * @var array
     */
    private $publicControllers = [
        ''
    ];

    /**
     * 初始化
     * @author     gongjt@xxcb.cn
     * @since      1.0
     */
    public function init()
    {
        parent::init();
        //组件：用户、缓存
        $components = array (
            'user' => array (
                'class' => 'backend\modules\admin\components\User',
                'enableAutoLogin' => TRUE,
                'identityCookie' => [
                    'name' => '_backendUser',
                    'path' => 'backend',
                ]
            ),
            'admincache' => array (
                'class' => '\yii\caching\FileCache',
                'cachePath' => Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'admincache'
            )
        );
        Yii::$app->set('user', NULL);
        Yii::$app->setComponents($components);
        Yii::$app->errorHandler->errorAction = 'admin/default/error';
//        $this->controllerMap = $this->getAdminControllerMap();
//        var_dump($this->controllerMap);
    }

    /**
     * 获取控制器地图
     */
    private function getAdminControllerMap()
    {
        $cacheId = 'admin/controller/map';
        if (!YII_ENV_DEV && ($cache = self::getCache()->get($cacheId)) !== FALSE)
        {
            return $cache;
        }
        else
        {
            self::getCache()->delete($cacheId);
        }

        $controllerMap = [];
        foreach (Yii::$app->getModules() as $name => $module)
        {
            if ($name == 'admin') continue;
            $path = Yii::getAlias('@backend/modules/' . $name . '/admin');

            if (!file_exists($path))
            {
                continue;
            }
            $controllers = FileHelper::findFiles($path, ['only' => ['/*Controller.php']]);
            foreach ($controllers as $file)
            {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $controllerName = strtolower(substr($fileName, 0, -10));
                $controllerMap[$name . '_' . $controllerName] = [
                    'class' => 'backend\\modules\\' . $name . '\\admin\\' . $fileName,
                    'ViewPath' => $path . '/views/' . $controllerName
                ];
            }
        }
        if (!YII_ENV_DEV)
        {
            self::getCache()->set($cacheId, $controllerMap);
        }
        return $controllerMap;
    }


    /**
     * 动作前置操作
     * @param \yii\base\Action $action
     * @return bool
     * 这个是权限控制用的 ，ADMIN模块下所有请求动作的前置验证
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) return FALSE;
        if (($sid = YII::$app->request->post('_sessionid', null)))
        {
            Yii::$app->session->setId($sid);
            Yii::$app->controller->enableCsrfValidation = FALSE;
        }
        $route =  'admin/' . Yii::$app->controller->id . '/' . $action->id;
        if (in_array($route, $this->guestPages))
        {
            return TRUE;
        }
        //游客
        if (\Yii::$app->user->isGuest)
        {
            \Yii::$app->user->loginRequired()->send();
            return false;
        }
        else
        {
            if (in_array(\Yii::$app->user->id, $this->superUserIds))
            {
                return TRUE;
            }
        }
        if (in_array($route, $this->guestPages))
        {
            return TRUE;
        }
        //公用页面
        if (in_array($route, $this->publicPages))
        {
            return TRUE;
        }
        //公用控制器
        if (in_array(Yii::$app->controller->id, $this->publicControllers))
        {
            return TRUE;
        }
        //权限提醒
        return TRUE;
    }

    /**
     * 返回后台缓存组件
     * @return \yii\caching\FileCache
     */
    public static function getCache()
    {
        return Yii::$app->admincache;
    }
}
