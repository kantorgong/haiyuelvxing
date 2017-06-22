<?php

namespace common\models\wxplus\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\wxplus\CarSnakeLog;

class CarSnakeLogSearch extends CarSnakeLog
{

    public function rules()
    {
        return [
                [['id', 'total', 'server_last_time'], 'integer'],
                [['nickname', 'open_id'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = CarSnakeLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
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
                $query->andWhere(['between' , 'start_time' , strtotime($beginDate), strtotime($beginDate)+86400]);
            }
            else
            {
                if(strtotime($endDate) > strtotime($beginDate))
                {
                    $query->andWhere(['between' , 'start_time' , strtotime($beginDate), strtotime($endDate)+86400]);
                }
                else
                {
                    if($endDate != $beginDate)
                        throw new NotFoundHttpException('开始时间不能小于结束时间');
                }
            }
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'total' => $this->total,
            'server_last_time' => $this->server_last_time,
            'open_id' => $this->open_id
        ]);

        $query->andFilterWhere(['like', 'nickname', trim($this->nickname)]);

        return $dataProvider;
    }
}
