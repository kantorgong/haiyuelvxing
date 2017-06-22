<?php

namespace backend\modules\wxplus\controllers;

use common\models\wxplus\search\CarSnakeLogSearch;
use Yii;

class CarSnakeController extends \backend\modules\wxplus\components\Controller
{
    public function actionIndex()
    {
        $searchModel = new CarSnakeLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }
}