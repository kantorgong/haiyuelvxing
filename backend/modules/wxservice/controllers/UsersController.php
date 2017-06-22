<?php

namespace backend\modules\wxservice\controllers;

use components\XyXy;
use Yii;
use yii\web\NotFoundHttpException;
use components\helper\CommonUtility;
use yii\data\ActiveDataProvider;
use common\models\wxservice\search\UsersSearch;

class UsersController extends \backend\modules\wxservice\components\Controller
{

    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }
}
