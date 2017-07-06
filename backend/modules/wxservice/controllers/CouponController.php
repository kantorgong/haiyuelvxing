<?php
/**
 * 优惠券
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2017/05/11 16:21
 * @since    1.0
 */

namespace backend\modules\wxservice\controllers;

use common\models\wxservice\search\CouponLogSearch;
use components\helper\CommonUtility;
use Yii;
use yii\data\ActiveDataProvider;
use common\models\wxservice\Coupon;
use common\models\wxservice\CouponLog;
class CouponController extends \backend\modules\wxservice\components\Controller
{
    public function actionIndex()
    {
        $searchModel = new Coupon();
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
        $model = new Coupon();
        if ($model->load(Yii::$app->request->post()))
        {
            $model->coupon_guid = CommonUtility::createGuid();
            if ($model->save())
            {

            }
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($coupon_id)
    {
        $model = Coupon::findOne($coupon_id);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {

            }

            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }


//    public function actionDelete($id)
//    {
//        Coupon::findOne($id)->delete();
//        $this->success('操作成功');
//    }

  //用户列表
    public function actionViewCouponLog()
    {
        $searchModel = new CouponLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
//        $dataProvider = new ActiveDataProvider([
////            'query' => $query,
////            'sort' => ['defaultOrder' => ['insert_time' => SORT_DESC]],
//            'pagination' => [
//                'pageSize' => 20,
//            ],
//        ]);
        return $this->render('viewcouponlog', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    //领取
    public function actionReceive($id)
    {
        $model = CouponLog::findOne($id);
        if ($model->load(Yii::$app->request->post()))
        {
//            var_dump($model);die;
            $model->operat_time = time();
            $model->operator_id = Yii::$app->user->identity->id;

            if ($model->save())
            {

            }

            return $this->redirect(['view-coupon-log', 'coupon_id' => $model->coupon_id]);
        }
        return $this->render('receive', ['model' => $model]);
    }
}