<?php
namespace frontend\modules\wechat\controllers;

use Yii;
use frontend\base\BaseFrontController;
use yii\helpers\VarDumper;

class SiteController extends BaseFrontController
{
    public function actionIndex()
    {
        $this->oauthCheck([
            'app_alias_name' => 'xxcb'
        ]);

        VarDumper::dump(Yii::$app->wechat->user);
    }
}
