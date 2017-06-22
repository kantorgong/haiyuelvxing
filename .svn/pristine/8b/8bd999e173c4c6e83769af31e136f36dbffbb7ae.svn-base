<?php

namespace backend\modules\cms;

use Yii;
use yii\web\HttpException;
use backend\modules\admin\components\User;

class ModuleCms extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\cms\controllers';

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
        if (!parent::beforeAction($action)) return false;

        if (($sid = YII::$app->request->post('_sessionid', null)))
        {
            Yii::$app->session->setId($sid);
            Yii::$app->controller->enableCsrfValidation = false;
        }

        $route = 'cms/' . Yii::$app->controller->id . '/' . $action->id;

        if (\Yii::$app->user->isGuest)
        {
            \Yii::$app->user->loginRequired()->send();
            return false;
        }
        else
        {
            if (in_array(\Yii::$app->user->id, $this->superUserIds))
            {

                return true;
            }
        }
        return true;
    }
}
