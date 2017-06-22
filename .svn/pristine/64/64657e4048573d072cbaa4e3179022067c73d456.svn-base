<?php
/**
 * 后台控制器类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/16 17:16
 * @since    1.0
 */

namespace backend\modules\admin\components;

use \backend\modules\admin\models\Log;

class Controller extends \components\web\BaseController
{

    public function beforeAction($action)
    {
        //记录日志
        //$this->_writerLog();
        return TRUE;
    }

    //记录系统日志
    private function _writerLog()
    {
        $model = new Log();
        $model->title = \yii::$app->name;
        $model->userid = \yii::$app->user->id;
        $model->username = \Yii::$app->user->identity->name;
        $model->created_at = time();
        $model->module = $this->module->id;
        $model->controller = \yii::$app->controller->id;
        $model->action = \yii::$app->controller->action->id;
        $model->url = \yii::$app->request->getPathInfo();
        $model->ip = \yii::$app->request->getUserIP();
        $model->save();
    }

}
