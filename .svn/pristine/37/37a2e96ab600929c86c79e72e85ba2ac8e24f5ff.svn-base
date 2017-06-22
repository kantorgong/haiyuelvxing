<?php
/**
 * TicketVenueSearch
 * 作者: limj
 * 版本: 17-1-10
 */

namespace common\models\xxcb\search;

use common\models\xxcb\TicketVenue;
use yii\data\ActiveDataProvider;
class TicketVenueSearch extends TicketVenue
{
    public function rules()
    {
        return [
            [['venue_id'], 'integer'],
            [['name', 'phone'], 'string'],
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
        $query->andFilterWhere([
            'phone' => $this->phone,
            'venue_id' => $this->venue_id,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
} 