<?php

/**
 * @filename DrawController.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-4-6 16:20:50
 * @version 1.0
 * @copyright (c) 2016-4-6, 潇湘晨报（版权）
 * @access public 权限
 */

namespace backend\modules\wxplus\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\activity\LotteryRules;
use components\helper\CommonUtility;
use yii\data\ActiveDataProvider;

class RulesController extends \backend\modules\wxplus\components\Controller
{

    public function actionIndex()
    {
        $searchModel = new LotteryRules();
        $query = $searchModel::find();
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => ['defaultOrder' => ['insert_time' => SORT_DESC]],
                'pagination' => [
                        'pageSize' => 20,
                ],
        ]);
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new LotteryRules();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                $redisMod = new \common\models\redis\LotteryRules;
                $this->saveRedis($model, $redisMod);
            }
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = LotteryRules::findOne($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                $redisMod = new \common\models\redis\LotteryRules;
                $this->saveRedis($model, $redisMod);
            }

            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }
}
