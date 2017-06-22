<?php

namespace backend\modules\admin\models;

use Yii;
use components\db;
use yii\db\ActiveRecord;

class Department extends \backend\modules\admin\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_department';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['insert_time', 'modify_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'modify_time',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parentid'], 'required'],
            [['display', 'parentid', 'listorder'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '部门编号',
            'name' => '部门名称',
            'display' => '禁用',
            'insert_time' => '插入时间',
            'modify_time' => '修改时间',
            'parentid' => '父级部门',
            'description' => '备注',
            'listorder' => '排序',
        ];
    }


    /**
     * 获取下拉
     * @param type $empty
     * @param type $pid
     * @return string
     */
    public static function getSelectTree($empty = NULL, $pid = 0, $noId = 0)
    {
        $rs = self::find()
            ->orderBy('listorder DESC')
            ->select('id, name, parentid')
            ->where('display = 0');


        if ($noId != 0)
        {
            $rs->where('id <> ' . $noId . ' AND parentid <>' . $noId);
        }
        $menus = $rs->asArray()->all();

        $tree = \components\helper\Tree::getInstance();
        $array = array ();
        foreach ($menus as $r)
        {
            $r['selected'] = ($pid != 0 && $pid == $r['id']) ? 'selected' : '';
            $array[] = $r;
        }

        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->setData($array);


        if ($empty !== NULL)
        {
            return '<option value="0">' . $empty . '</option>' . $tree->get_tree('0', $str);
        }
        else
        {
            return $tree->get_tree('0', $str);
        }
    }


}
