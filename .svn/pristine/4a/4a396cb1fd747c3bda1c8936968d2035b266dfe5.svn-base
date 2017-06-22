<?php
/**
 * @File: OauthController.php
 * @User: zhujw <zhjw@xxcb.cn>
 * @Date: 2016/6/22 17:38
 * @Desc: 网页授权控制器类
 */
namespace frontend\modules\wechat\controllers;

use Yii;
use yii\web\Controller;

class OauthController extends Controller
{
    //$path用于vue.js路由问题
    public function actionCallback($path='')
    {
        return Yii::$app->wechat->authorizeRequired(Yii::$app->request->referrer . $path)->send();
    }
}