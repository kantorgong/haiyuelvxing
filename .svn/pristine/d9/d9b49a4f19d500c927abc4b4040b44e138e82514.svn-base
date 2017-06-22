<?php
/**
 * 日志控制器
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2016/1/14 17:02
 * @since    1.0
 */

namespace backend\modules\admin\controllers;

use Yii;
use backend\modules\admin\models\Log;
use backend\modules\admin\models\search\LogSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use components\deploy\GlobalHelper;
use components\helper\LogHelper;
use yii\data\Pagination;//分页类

class LogController extends \backend\modules\admin\components\Controller
{
    public function actionIndex()
    {
        $searchModel = new LogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Log();
        if ($model->load(Yii::$app->request->post()))
        {

            if ($model->save())
            {
                return $this->redirect(['index']);
            }
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        $this->success('操作成功');
    }

    protected function findModel($id)
    {
        if ($id !== null && ($model = Log::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}