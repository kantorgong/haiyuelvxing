<?php
/**
 * 权限搜索类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/23 21:59
 * @since    1.0
 */

namespace backend\modules\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\admin\models\Role;

/**
 * RoleSearch represents the model behind the search form about Role.
 */
class RoleSearch extends Model
{
    public $id;
    public $name;
    public $description;
    public $disabled;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return [
            [['id', 'disabled', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '角色名',
            'description' => '说明',
            'disabled' => '启用',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
        ];
    }

    public function search($params)
    {
        $query = Role::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'name', true);
        $this->addCondition($query, 'description', true);
        $this->addCondition($query, 'disabled');
        $this->addCondition($query, 'created_at');
        $this->addCondition($query, 'updated_at');
        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '')
        {
            return;
        }
        if ($partialMatch)
        {
            $query->andWhere(['like', $attribute, $value]);
        }
        else
        {
            $query->andWhere([$attribute => $value]);
        }
    }
}
