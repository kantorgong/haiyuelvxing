<?php

namespace backend\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\admin\models\Department;

/**
 * DepartmentSearch represents the model behind the search form about `backend\modules\admin\models\Department`.
 */
class DepartmentSearch extends Department
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dpt_id', 'status', 'insert_time', 'modify_time', 'parent_id', 'sort'], 'integer'],
            [['dpt_name', 'memo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Department::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'dpt_id' => $this->dpt_id,
            'status' => $this->status,
            'insert_time' => $this->insert_time,
            'modify_time' => $this->modify_time,
            'parent_id' => $this->parent_id,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'dpt_name', $this->dpt_name])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
}
