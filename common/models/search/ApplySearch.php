<?php

/**
 * @filename ApplySearch.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-23 10:35:53
 * @version 1.0
 * @copyright (c) 2016-3-23, 潇湘晨报（版权）
 * @access public 权限
 */

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Apply;
use yii\web\NotFoundHttpException;

class ApplySearch extends Apply
{

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function rules()
    {
        return [
            [['id','start_time', 'end_time', 'is_use'], 'integer'],
            [['title', 'guid'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Apply::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['insert_time' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_use' => $this->is_use,
            'guid' => trim($this->guid)
        ]);

        $query->andFilterWhere(['like', 'title', trim($this->title)]);

        return $dataProvider;
    }

}

?>