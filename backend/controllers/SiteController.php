<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        return  [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        //返回后台首页
        return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
    }

    //错误
    public function actionError()
    {
        if($error=Yii::$app->errorHandler->error)
        {
            print_r($error);
            if(Yii::$app->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}
