<?php
/**
 * ExtendController
 * 作者: limj
 * 版本: 17-4-19
 */

namespace backend\modules\wxservice\controllers;
use Yii;
use common\models\wxservice\search\CustomExtendSearch;
use common\models\wxservice\CustomExtend;
use common\models\wxservice\CustomAppsExtend;
class ExtendController extends \backend\modules\wxplus\components\Controller
{
    public function actionIndex()
    {
        $searchModel = new CustomExtendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new CustomExtend();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
            else
            {
                Yii::error('新增扩展失败：' . var_export($model->getErrors(), true));
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = CustomExtend::findOne($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
            else
            {
                Yii::error('更新扩展失败：' . var_export($model->getErrors(), true));
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionAjax()
    {
        $kid = \Yii::$app->request->get('kid');
        $pid = \Yii::$app->request->get('pid');
        $model = CustomAppsExtend::find()->where(['kid'=>$kid, 'pid'=>$pid])->one();
        if(\Yii::$app->request->get('type') == 1)
        {
            // 新增模块
            if(empty($model))
            {
                $mod = new CustomAppsExtend();
                $mod->pid = $pid;
                $mod->kid = $kid;
                if($mod->save())
                {
                    $this->success('操作成功');
                }
            }
        }
        elseif(\Yii::$app->request->get('type') == 2)
        {
            // 取消模块
            if($model)
            {
                $res = $model->delete();
                if($res)
                {
                    $this->success('操作成功');
                }
            }
        }
        $this->error('操作失败');
    }
} 