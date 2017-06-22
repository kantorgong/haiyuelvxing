<?php
/**
 * 自定义变量搜索类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/10/12 16:20
 * @since    1.0
 */
namespace common\models\search;

use common\models\Sysvariable;
use yii\data\ActiveDataProvider;

class SysvariableSearch extends Sysvariable
{
    public function rules()
    {
        return [
            [['id', 'name', 'value', 'note'], 'safe'],
            [['data_type', 'is_cache'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = $this->find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'data_type' => $this->data_type,
            'is_cache' => $this->is_cache,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
