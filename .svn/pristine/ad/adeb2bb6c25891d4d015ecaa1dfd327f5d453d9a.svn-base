<?php

namespace frontend\modules\activity\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\wxservice\CmsPageView;

class PageViewController extends \frontend\modules\activity\components\Controller
{
    public $layout = false;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @Desc: 用于统计前端页面的访问次数，直接在JS中引入即可，页面中可获取变量_pageView
     * @User: zhujw <zhjw@xxcb.cn>
     * @throws NotFoundHttpException
     */
    public function actionJs()
    {
        $params = array_keys(Yii::$app->request->get());
        $guid = isset($params[1]) ? $params[1] : '';
        if (!$guid) throw new NotFoundHttpException();

        $page = CmsPageView::find()->where(['guid' => $guid])->select(['id', 'link', 'show', 'view'])->one();
        if (!$page) throw new NotFoundHttpException();

        //访问来源判断
        $src = Yii::$app->request->referrer;
        if (!$src) throw new NotFoundHttpException();

        if (strpos($src, '?') === false)
        {
            $link = $src;
        }
        else
        {
            $srcArr =  explode('?', $src);
            $link = $srcArr[0];
        }
        if (strpos($page['link'], $link) === false) throw new NotFoundHttpException();

        //访问次数+1
        $counters = ['view' => 1];
        $page['show'] && $counters['show'] = 1;
        CmsPageView::updateAllCounters($counters, ['id' => $page['id']]);
        $show = $page['show'] ? ++$page['show'] : ++$page['view'];

        echo 'var _pageView = ' . $show;
        Yii::$app->end();
    }
}
