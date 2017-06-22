<?php

namespace backend\modules\wxservice\controllers;

use components\helper\CommonUtility;
use Yii;
use common\models\wxservice\LotteryActiveGroup;
use yii\data\ActiveDataProvider;

class ActivegroupController extends \backend\modules\wxservice\components\Controller
{

    public function actionIndex()
    {
        $searchModel = new LotteryActiveGroup();
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
        $model = new LotteryActiveGroup();
        if ($model->load(Yii::$app->request->post()))
        {
            $model->group_id = CommonUtility::createGuid();
            if ($model->save())
            {

            }
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = LotteryActiveGroup::findOne($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {

            }

            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }


    public function actionDelete($id)
    {
        LotteryActiveGroup::findOne($id)->delete();
        $this->success('操作成功');
    }
}