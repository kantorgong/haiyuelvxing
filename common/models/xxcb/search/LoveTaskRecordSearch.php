<?php

namespace common\models\xxcb\search;

use common\models\xxcb\LoveTaskRecord;
use yii\data\ActiveDataProvider;

class LoveTaskRecordSearch extends LoveTaskRecord
{
    public function rules()
    {
        return [
                [['rid', 'uid', 'day'], 'integer']
        ];
    }

    public function search($params)
    {
        $query = LoveTaskRecord::find();

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => ['defaultOrder' => ['uid' => SORT_DESC]],
                'pagination' => [
                        'pageSize' => 20,
                ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
                'rid' => $this->rid,
                'uid' => $this->uid,
                'day' => $this->day
        ]);

        return $dataProvider;
    }
} 