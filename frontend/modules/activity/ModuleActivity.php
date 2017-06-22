<?php
/**
 * cms模块类
 *
 */

namespace frontend\modules\activity;
use Yii;

class ModuleActivity extends \yii\base\Module
{

    public function init()
    {
        $urlArr = explode('/', trim(\Yii::$app->request->url, '/'));
        $url = $urlArr[0] . '/' . $urlArr[1];
        if(in_array($url, array('activity/answer','activity/scratch-card')))
        {
            Yii::$app->errorHandler->errorAction = 'activity/answer/notice';
        }
        if(in_array($url, array('activity/school')))
        {
            Yii::$app->errorHandler->errorAction = 'activity/school/error';
        }
        parent::init();
    }

}
