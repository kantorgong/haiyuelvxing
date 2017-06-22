<?php
/**
 * CustomController
 * 作者: limj
 * 版本: 17-4-18
 */

namespace backend\modules\wxservice\controllers;
use Yii;
use common\models\wxservice\search\CustomUserSearch;
use common\models\wxservice\CustomUser;
use common\models\wxservice\WxApps;
use common\models\wxservice\CustomApps;
use yii\data\ActiveDataProvider;
class CustomController extends \backend\modules\wxplus\components\Controller
{
    public function actionIndex()
    {
        $searchModel = new CustomUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new CustomUser();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
            else
            {
                Yii::error('新增用户失败：' . var_export($model->getErrors(), true));
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = CustomUser::findOne($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
            else
            {
                Yii::error('更新用户失败：' . var_export($model->getErrors(), true));
            }
        }
        $model->passwd = '';
        return $this->render('update', ['model' => $model]);
    }

    public function actionView($id)
    {
        $searchModel = new WxApps();
        $query = $searchModel::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['insert_time' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        // 获取所有已经被选择了的公众号

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionAjax()
    {
        $uid = \Yii::$app->request->get('uid');
        $pid = \Yii::$app->request->get('pid');
        $model = WxApps::find()->where(['belong_user_id'=>$uid, 'pid'=>$pid])->one();
        if(\Yii::$app->request->get('type') == 1)
        {
            if(empty($model))
            {
                $mod = WxApps::findOne($pid);
                $mod->belong_user_id = $uid;
//                $mod->pid = $pid;
                if($mod->save())
                {
                    $this->success('操作成功');
                }
            }
        }
        elseif(\Yii::$app->request->get('type') == 2)
        {
            if($model)
            {
                $model->belong_user_id = 0;
                if($model->save())
                {
                    $this->success('操作成功');
                }
            }
        }
        $this->error('操作失败');
    }
} 