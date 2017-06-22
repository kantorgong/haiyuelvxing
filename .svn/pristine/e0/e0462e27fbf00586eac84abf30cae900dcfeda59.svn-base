<?php

namespace common\models\wxservice\search;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\wxservice\Users;
use yii\web\NotFoundHttpException;

class UsersSearch extends Users
{
    public function rules()
    {
        return [
            [['uid', 'sex'], 'integer'],
            [['open_id', 'nickname'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['insert_time' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if(!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        //发布时间区间
        $insert_time_range = $params['Search']['insert_time_range'];
        $modify_time_range = $params['Search']['modify_time_range'];
        if(isset($insert_time_range))
        {
            $insert_time_range = str_replace(' ', '', $insert_time_range);
            $beginDate = substr($insert_time_range, 0, 10);
            $endDate = substr($insert_time_range, 11, 21);
            //昨天，今天的情况
            if($beginDate == $endDate &&  $beginDate != 0)
            {
                $query->andWhere(['between' , 'insert_time' , strtotime($beginDate), strtotime($beginDate)+86400]);
            }
            else
            {
                if(strtotime($endDate) > strtotime($beginDate))
                {
                    $query->andWhere(['between' , 'insert_time' , strtotime($beginDate), strtotime($endDate)+86400]);
                }
                else
                {
                    if($endDate != $beginDate)
                        throw new NotFoundHttpException('开始时间不能小于结束时间');
                }
            }
        }

        if(isset($modify_time_range))
        {
            $modify_time_range = str_replace(' ', '', $modify_time_range);
            $beginDate = substr($modify_time_range, 0, 10);
            $endDate = substr($modify_time_range, 11, 21);
            //昨天，今天的情况
            if($beginDate == $endDate &&  $beginDate != 0)
            {
                $query->andWhere(['between' , 'modify_time' , strtotime($beginDate), strtotime($beginDate)+86400]);
            }
            else
            {
                if(strtotime($endDate) > strtotime($beginDate))
                {
                    $query->andWhere(['between' , 'modify_time' , strtotime($beginDate), strtotime($endDate)+86400]);
                }
                else
                {
                    if($endDate != $beginDate)
                        throw new NotFoundHttpException('开始时间不能小于结束时间');
                }
            }
        }

        $query->andFilterWhere([
            'uid' => trim($this->uid),
            'open_id' => trim($this->open_id),
            'sex' => $this->sex
        ]);

        $query->andFilterWhere(['like', 'nickname', trim($this->nickname)]);

        return $dataProvider;
    }

}