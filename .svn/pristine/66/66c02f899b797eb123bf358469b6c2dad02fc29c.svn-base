<?php

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\wxservice\CmsPageView;
use common\models\wxservice\search\CmsPageViewSearch;

class PageViewController extends \backend\modules\cms\components\Controller
{

    public function actionIndex()
    {
        $searchModel = new CmsPageViewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new CmsPageView();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
            else {
                \components\XyXy::dump($model->errors);
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
        $this->findModel($id)->delete();
        $this->success('操作成功');
    }

    protected function findModel($id)
    {
        if ($id !== null && ($model = CmsPageView::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

?>