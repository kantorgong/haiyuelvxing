<?php
/**
 * 优惠券日志模型
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2017/05/11 16:23
 * @since    1.0
 */

namespace common\models\wxservice\search;

use common\models\wxservice\Coupon;
use Yii;
use common\models\wxservice\CouponLog;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
class CouponLogSearch extends CouponLog
{
    public function rules()
    {
        return [
            [['status', 'userid'], 'integer'],
            [['open_id', 'nickname'], 'string']
        ];
    }


    public function search($params)
    {
        $query = CouponLog::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort' => ['defaultOrder' => ['insert_time' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        if ($params['coupon_id'] > 0)
        {
            $query->andFilterWhere([
                'coupon_id' => trim($params['coupon_id'])
            ]);
        }

        if ($params['CouponLogSearch']['open_id'] > 0)
        {
            $query->andFilterWhere([
                'open_id' => trim($params['CouponLogSearch']['open_id'])
            ]);
        }

        if ($params['CouponLogSearch']['status'] > -1)
        {

            $query->andFilterWhere([
                'status' => trim(intval($params['CouponLogSearch']['status']))
            ]);
        }

        if (intval($params['CouponLogSearch']['userid']) > 0)
        {
            $query->andFilterWhere([
                'userid' => trim(intval($params['CouponLogSearch']['userid']))
            ]);
        }



        if ($params['CouponLogSearch']['nickname'] != '')
        {
            $query->andFilterWhere([
                'nickname' => trim($params['nickname'])
            ]);
        }

//        //发布时间区间
//        $insert_time_range = $params['Search']['insert_time_range'];
//        $modify_time_range = $params['Search']['modify_time_range'];
//        if(isset($insert_time_range))
//        {
//            $insert_time_range = str_replace(' ', '', $insert_time_range);
//            $beginDate = substr($insert_time_range, 0, 10);
//            $endDate = substr($insert_time_range, 11, 21);
//            //昨天，今天的情况
//            if($beginDate == $endDate &&  $beginDate != 0)
//            {
//                $query->andWhere(['between' , 'insert_time' , strtotime($beginDate), strtotime($beginDate)+86400]);
//            }
//            else
//            {
//                if(strtotime($endDate) > strtotime($beginDate))
//                {
//                    $query->andWhere(['between' , 'insert_time' , strtotime($beginDate), strtotime($endDate)+86400]);
//                }
//                else
//                {
//                    if($endDate != $beginDate)
//                        throw new NotFoundHttpException('开始时间不能小于结束时间');
//                }
//            }
//        }



//
//        $query->andFilterWhere(['like', 'nickname', trim($this->nickname)]);



        return $dataProvider;
    }
}