<?php
/**
 * 名称
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2016/11/22 20:10
 * @since    1.0
 */

namespace backend\modules\wxplus\controllers;

use components\helper\CommonUtility;
use components\helper\IpHelper;
use Yii;
use yii\web\NotFoundHttpException;
use common\models\wxplus\Activegroup;
use yii\data\ActiveDataProvider;

class ActivegroupController extends \backend\modules\wxplus\components\Controller
{

    public function actionIndex()
    {
        $searchModel = new Activegroup();
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
        $model = new Activegroup();
        if ($model->load(Yii::$app->request->post()))
        {
            $model->group_id = CommonUtility::createGuid();
            if ($model->save())
            {
                $redisMod = new \common\models\redis\LotteryActiveGroup;
                $this->saveRedis($model, $redisMod);
            }
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Activegroup::findOne($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                $redisMod = new \common\models\redis\LotteryActiveGroup;
                $this->saveRedis($model, $redisMod);
            }

            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }


    public function actionDelete($id)
    {
        Activegroup::findOne($id)->delete();
        $this->success('操作成功');
    }
}