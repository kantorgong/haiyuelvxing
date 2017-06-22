<?php

/**
 * @filename ApplyoptionSearch.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 16:03:42
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */
namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Applyoption;
use yii\web\NotFoundHttpException;

class ApplyoptionSearch extends Applyoption
{

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function rules()
    {
        return [
                [['id'], 'integer'],
                [['info_name', 'info_label', 'info_title', 'info_type'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Applyoption::find();

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
            'id' => trim($this->id),
            'info_name' => trim($this->info_name),
            'info_label' => trim($this->info_label),
            'info_type' => trim($this->info_type)
        ]);

        $query->andFilterWhere(['like', 'info_title', trim($this->info_title)]);

        return $dataProvider;
    }

}

?>