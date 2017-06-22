<?php
/**
 * CustomExtendSearch
 * 作者: limj
 * 版本: 17-4-19
 */

namespace common\models\wxservice\search;
use Yii;
use yii\data\ActiveDataProvider;
use common\models\wxservice\CustomExtend;
use yii\web\NotFoundHttpException;

class CustomExtendSearch extends CustomExtend
{
    public function rules()
    {
        return [
            [['kid', 'status'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = CustomExtend::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if(!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'kid' => $this->kid,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
} 