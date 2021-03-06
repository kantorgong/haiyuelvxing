<?php

namespace backend\modules\admin\controllers;

use Yii;
use yii\web;
use backend\modules\admin\form\LoginForm;
use common\models\wxserver\Wxuser;


class DefaultController extends \backend\modules\admin\components\Controller
{

    public function actions()
    {
        return  [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0x000000,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 5,//间距
                'height'=>34,//高度
                'width' => 80,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4,        //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSysindex()
    {

//        $modeluser = new Wxuser();
//
//        $modeluser->userid  = 20000;
//        $modeluser->name = '张三';
//        $modeluser->age = 12;
//
//        $modeluser->save();
//
//        $usernew = new Wxuser();
//        $user = $usernew->find()->andWhere(['name' => '张三'])->all();
//        var_dump($user);die;





        return $this->render('sysindex');
    }

    public function actionMain()
    {
//        $name = Yii::$app->user->identity->id;
        return $this->render('main');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            $this->redirect(['index']);
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            $this->redirect(['index']);
        }
        else
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout(false);
        return $this->goHome();
    }

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
