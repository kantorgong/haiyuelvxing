<?php
/**
 * CustomUserSearch
 * 作者: limj
 * 版本: 17-4-18
 */

namespace common\models\wxservice\search;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\wxservice\CustomUser;
use yii\web\NotFoundHttpException;

class CustomUserSearch extends CustomUser
{

    public function rules()
    {
        return [
            [['uid', 'status', 'user_group'], 'integer'],
            [['nick_name', 'user_name'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = CustomUser::find();

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
            'uid' => $this->uid,
            'user_group' => $this->user_group,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'nick_name', $this->nick_name]);
        $query->andFilterWhere(['like', 'user_name', $this->user_name]);

        return $dataProvider;
    }
} 