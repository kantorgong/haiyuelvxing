<?php
/**
 * 数据字典控制器
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/25 21:00
 * @since    1.0
 */

namespace backend\modules\admin\controllers;


use Yii;
use common\models\Dict;
use yii\web\NotFoundHttpException;
use components\XyXy;
use common\models\DictCategory;
use components\helper\CacheUtility;
use yii\filters\VerbFilter;
use components\web\BaseView;
use yii\web\HttpException;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
/**
 * DictController implements the CRUD actions for Dict model.
 */
class DictController extends \backend\modules\admin\components\Controller
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
     * Lists all Dict models.
     * @return mixed
     */
    public function actionIndex($catid, $pid = 0)
    {
        $query = Dict::find()->where(['parent_id' => $pid, 'category_id' => $catid]);
        $locals = XyXy::getPagedRows($query, ['order' => 'id DESC, sort_num DESC']);
//        $locals['pid'] = $pid;
//        $locals['parent'] = $this->findModel($pid);
//        $locals['parents'] = Dict::getParents($pid);
//
//        $locals['category'] = DictCategory::findOne($catid);
        return $this->render('index', $locals);
    }


    /**
     * Creates a new Dict model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($catid, $pid = 0)
    {
        $model = new Dict;
        $model->parent_id = $pid;
        $model->category_id = $catid;
        if ($model->load(Yii::$app->request->post()))
        {
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

                $model->save();
                return $this->redirect(['index', 'pid' => $pid, 'catid' => $catid]);

        }
        else
        {
            $locals = [];
            $locals['model'] = $model;
            $locals['parent'] = $this->findModel($pid);
            $locals['parents'] = Dict::getParents($pid);
            $locals['category'] = DictCategory::findOne($catid);
            return $this->render('create', $locals);
        }
    }

    /**
     * Updates an existing Dict model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pid = $model->parent_id;
        $catid = $model->category_id;

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
            $locals = [];
            $locals['model'] = $model;
            $locals['parent'] = $this->findModel($pid);
            $locals['parents'] = Dict::getParents($pid);
            $locals['category'] = DictCategory::findOne($catid);
            return $this->render('update', $locals);
        }
    }

    /**
     * Deletes an existing Dict model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $catid)
    {
        $this->findModel($id)->delete();
        CacheUtility::createDictCache();
        $this->success('操作成功');
    }

    /**
     * Finds the Dict model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dict the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id = intval($id);

        if ($id === 0)
        {
            $model = new Dict();
            $model->id = 0;
            $model->name = '根字典';
            return $model;
        }

        if (($model = Dict::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            //throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

