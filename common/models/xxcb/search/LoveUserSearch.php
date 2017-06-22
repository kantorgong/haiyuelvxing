<?php

namespace common\models\xxcb\search;

use common\models\xxcb\LoveUser;
use yii\data\ActiveDataProvider;

class LoveUserSearch extends LoveUser
{
    public function rules()
    {
        return [
                [['uid'], 'integer'],
                [['nickname', 'sex', 'orientation'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = LoveUser::find()->Where('nickname != "" AND (start_time = 0 or start_time > insert_time)');

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => ['defaultOrder' => ['uid' => SORT_DESC]],
                'pagination' => [
                        'pageSize' => 100,
                ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
                'uid' => $this->uid,
                'mate_uid' => $this->mate_uid
        ]);

        $query->andFilterWhere(['like', 'nickname', trim($this->nickname)]);
        $query->andFilterWhere(['like', 'sex', trim($this->sex)]);
        $query->andFilterWhere(['like', 'orientation', trim($this->orientation)]);

        return $dataProvider;
    }
} 