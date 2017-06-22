<?php
/**
 * 服务模块
 */

namespace backend\modules\service;

use Yii;
use yii\web\HttpException;
use backend\modules\admin\components\User;

class ModuleService extends \yii\base\Module
{
	public $controllerNamespace = 'backend\modules\service\controllers';

    public $superUserIds = [];
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
    }


    /**
     * 动作前置操作
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        return true;
    }
}
