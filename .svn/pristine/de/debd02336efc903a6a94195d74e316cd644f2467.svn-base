<?php
/**
 * 错误日志搜索类
 */

namespace backend\modules\admin\models\search;

use yii\data\ActiveDataProvider;
use backend\modules\admin\models\ErrorLog;

/**
 * RoleSearch represents the model behind the search form about Role.
 */
class ErrorLogSearch extends ErrorLog
{
    public function rules()
    {
        return [
                [['level'], 'integer'],
                [['category', 'prefix', 'message'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = ErrorLog::find();

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => ['defaultOrder' => ['log_time' => SORT_DESC]],
                'pagination' => [
                        'pageSize' => 50,
                ],
        ]);

        if(!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
                'level' => $this->level,
                'category' => $this->category
        ]);

        $query->andFilterWhere(['like', 'prefix', $this->prefix]);
        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
