<?php

namespace common\models\wxservice\search;

use yii\data\ActiveDataProvider;
use common\models\wxservice\CmsPageView;

class CmsPageViewSearch extends CmsPageView
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'link', 'guid'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = CmsPageView::find();

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
            'guid' => $this->guid
        ]);

        $query->andFilterWhere(['like', 'title', trim($this->title)]);
        $query->andFilterWhere(['like', 'link', trim($this->link)]);

        return $dataProvider;
    }

}