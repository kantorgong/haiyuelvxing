<?php

namespace backend\modules\wxservice\controllers;

use components\helper\CommonUtility;
use Yii;
use common\models\wxservice\WxApps;
use yii\data\ActiveDataProvider;
use common\models\wxservice\CustomExtend;
class WxAppsController extends \backend\modules\wxservice\components\Controller
{
    /**
     * @Desc: 列表页，不做分页和查询功能
     * @User: zhujw <zhjw@xxcb.cn>
     * @return string
     */
    public function actionIndex()
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
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @Desc: 添加公众号
     * @User: zhujw <zhjw@xxcb.cn>
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WxApps();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save() && !$model->attributes['disabled'])
            {
                //保存到redis，使用easywechat的格式
                $redisData = $this->_setRedisData($model);
                Yii::$app->redis->set('wx_apps:' . $model->attributes['alias_name'], \GuzzleHttp\json_encode($redisData));
            }
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * @Desc: 设置redis配置格式
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $model
     * @return array
     */
    private function _setRedisData($model)
    {
        return [
                'debug'     => false,
                'app_id'    => $model->attributes['app_id'],
                'secret'    => $model->attributes['app_key'],
                'token'     => $model->attributes['app_token'],
                'oauth' => [
                        'callback' => '/wechat/oauth/callback.html',
                        'scopes'   => ['snsapi_userinfo'],
                ],
                'payment' => [
                    'merchant_id' => $model->attributes['payment_merchant_id'],
                    'key' => $model->attributes['payment_key']
                ]
        ];
    }

    /**
     * @Desc: 更新公众号
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = WxApps::findOne($id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                if ($model->attributes['disabled'])
                {
                    Yii::$app->redis->del('wx_apps:' . $model->attributes['alias_name']);
                }
                else
                {
                    //保存到redis，使用easywechat的格式
                    $redisData = $this->_setRedisData($model);
                    Yii::$app->redis->set('wx_apps:' . $model->attributes['alias_name'], \GuzzleHttp\json_encode($redisData));
                }
            }
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionExtend($id)
    {
        $searchModel = new CustomExtend();
        $query = $searchModel::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['insert_time' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        // 获取所有已经被选择了的公众号
        return $this->render('extend', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}