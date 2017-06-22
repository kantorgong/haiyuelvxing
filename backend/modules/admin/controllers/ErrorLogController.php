<?php
/**
 * 错误日志控制器
 */

namespace backend\modules\admin\controllers;

use Yii;
use backend\modules\admin\models\ErrorLog;
use backend\modules\admin\models\search\ErrorLogSearch;

class ErrorLogController extends \backend\modules\admin\components\Controller
{
    private $_redisLogKy = 'error_log_redis_key';

    public function actionIndex()
    {
        $redis = Yii::$app->redis;
        if (Yii::$app->request->isPost)
        {
            $name = Yii::$app->request->post('name');
            if ($redis->HEXISTS($this->_redisLogKy, $name))
            {
                Yii::$app->session->setFlash('error', '日志点已存在');
            }
            else
            {
                $redis->hset($this->_redisLogKy, $name, 0);
                Yii::$app->session->setFlash('success', '日志点添加成功');
            }
        }

        //只保留3天之内的数据，所以之前的数据会被删除
        ErrorLog::deleteAll(['<', 'log_time', strtotime('-3 day')]);
        $searchModel = new ErrorLogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'list' => $redis->hkeys($this->_redisLogKy),
            'key' => $this->_redisLogKy
        ]);
    }

    public function actionUpdate($key)
    {
        $redis = Yii::$app->redis;
        $redis->hset($this->_redisLogKy, $key, $redis->hget($this->_redisLogKy, $key) ? 0 : 1);
        $this->success('日志状态修改成功');
    }
}