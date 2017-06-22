<?php

namespace common\models\activity\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\activity\LotteryList;

class LotteryListSearch extends LotteryList
{

    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function rules()
    {
        return [
            [['type', 'attention', 'status', 'bonus'], 'integer'],
            [['act_name', 'guid', 'group_id'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = LotteryList::find();

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

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'guid' => $this->guid,
            'attention' => $this->attention,
            'status' => $this->status,
            'share' => $this->share,
            'bonus' => $this->bonus,
            'group_id' => $this->group_id
        ]);

        $query->andFilterWhere(['like', 'act_name', $this->act_name]);

        return $dataProvider;
    }

}