<?php

namespace backend\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\admin\models\Log;

/**
 * DepartmentSearch represents the model behind the search form about `backend\modules\admin\models\Department`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'username', 'ip', 'url', 'created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = Log::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            return $dataProvider;
        }


        //时间区间
        $created_at_range = $params['LogSearch']['created_at_range'];
        if (isset($created_at_range))
        {
            $created_at_range = str_replace(' ', '', $created_at_range);
            $beginDate = substr($created_at_range, 0, 10);
            $endDate = substr($created_at_range, 11, 21);
            //昨天，今天的情况
            if ($beginDate == $endDate && $beginDate != 0)
            {
                $query->andWhere(['between', 'created_at', strtotime($beginDate), strtotime($beginDate) + 86400]);
            }
            else
            {
                if (strtotime($endDate) > strtotime($beginDate))
                {
                    $query->andWhere(['between', 'created_at', strtotime($beginDate), strtotime($endDate) + 86400]);
                }
                else
                {
                    if ($endDate != $beginDate)
                    {
                        throw new NotFoundHttpException('开始时间不能小于结束时间');
                    }
                }
            }
        }


        $query->andFilterWhere([
            'userid' => $this->userid,
            'ip' => $this->ip,
        ]);


        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'url', $this->url]);

        $query->orderBy('created_at DESC');
        return $dataProvider;
    }
}
