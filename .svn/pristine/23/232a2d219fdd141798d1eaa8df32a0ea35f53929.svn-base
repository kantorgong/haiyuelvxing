<?php

namespace backend\modules\wxservice\controllers;

use Yii;
use common\models\wxservice\LotteryRules;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class RulesController extends \backend\modules\wxservice\components\Controller
{

    private $redisKey = 'lottery_rules:global';

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
                $arr = $this->unsetRedisField(ArrayHelper::toArray($model));
                Yii::$app->redis->set($this->redisKey, \GuzzleHttp\json_encode($arr));
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
                $arr = $this->unsetRedisField(ArrayHelper::toArray($model));
                Yii::$app->redis->set($this->redisKey, \GuzzleHttp\json_encode($arr));
            }

            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }
}
