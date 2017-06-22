<?php
/**
 * 数据字典控制器
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/25 20:56
 * @since    1.0
 */

namespace backend\modules\admin\controllers;


use Yii;
use common\models\DictCategory;
use common\models\search\DictCategorySearch;
use backend\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use components\helper\CacheUtility;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
/**
 * DictcategoryController implements the CRUD actions for Dictcategory model.
 */
class DictcategoryController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete, refreshdict' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dictcategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DictcategorySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Creates a new Dictcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dictcategory;

        if ($model->load(Yii::$app->request->post()))
        {
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $model->save();
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
     * Updates an existing Dictcategory model.
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
     * Deletes an existing Dictcategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        CacheUtility::createDictCache();
        $this->success('操作成功');
    }

    //刷新缓存
    public function actionRefreshdict()
    {
        CacheUtility::createDictCache();
        $this->success('操作成功');
    }
    /**
     * Finds the Dictcategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dictcategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dictcategory::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
