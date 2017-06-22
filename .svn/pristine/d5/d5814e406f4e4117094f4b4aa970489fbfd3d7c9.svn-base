<?php

namespace common\models\wxservice\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wxservice\LotteryWinner;

class LotteryWinnerSearch extends LotteryWinner
{

    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function rules()
    {
        return [
            [['id', 'prize_id', 'act_id', 'is_share'], 'integer'],
            [['open_id'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = LotteryWinner::find();

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
            'prize_id' => $this->prize_id,
            'act_id' => $this->act_id,
            'is_share' => $this->is_share,
            'open_id' => $this->open_id,
        ]);


        return $dataProvider;
    }

}
