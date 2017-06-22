<?php
/**
 * 自定义变量控制器
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/10/12 16:17
 * @since    1.0
 */

namespace backend\modules\admin\controllers;

use Yii;
use common\models\Sysvariable;
use common\models\search\SysvariableSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use components\helper\CacheUtility;
use yii\web\HttpException;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

class SysvariableController extends \backend\modules\admin\components\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all sysvariable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysvariableSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Creates a new sysvariable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sysvariable;
        if ($model->load(Yii::$app->request->post()))
        {
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $model->save();
            CacheUtility::createVariableCache();
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing sysvariable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $model->save();
            CacheUtility::createVariableCache();
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing sysvariable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $this->success('操作成功');
    }

    /**
     * Finds the sysvariable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return sysvariable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = sysvariable::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
