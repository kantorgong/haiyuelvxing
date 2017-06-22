<?php
/**
 * TicketActivity
 * 作者: limj
 * 版本: 17-1-4
 */

namespace common\models\xxcb\search;

use common\models\xxcb\TicketActivity;
use yii\data\ActiveDataProvider;
class TicketActivitySearch extends TicketActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['title'], 'string'],
        ];
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
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        return $dataProvider;
    }
} 