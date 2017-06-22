<?php
/**
 * 数据字典分类搜索类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/25 20:54
 * @since    1.0
 */
namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DictCategory;

/**
 * DictCategorySearch represents the model behind the search form about `common\models\DictCategory`.
 */
class DictCategorySearch extends DictCategory
{
    public function rules()
    {
        return [
            [['key', 'name', 'description'], 'safe'],
            [['is_sys'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DictCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'is_sys' => $this->is_sys,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
