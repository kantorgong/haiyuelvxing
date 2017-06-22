<?php
/**
 * 菜单模型
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/16 14:04
 * @since    1.0
 */

namespace backend\modules\admin\models;

use components\db;
use yii\db\ActiveRecord;

class Menu extends \backend\modules\admin\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentid', 'listorder', 'display'], 'integer'],
            [['controller'], 'required'],
            [['name', 'icon'], 'string', 'max' => 50],
            [['controller', 'action'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '菜单ID',
            'name' => '菜单名',
            'icon' => '图标',
            'parentid' => '上级菜单ID',
            'controller' => '控制器',
            'action' => '动作',
            'description' => '说明',
            'listorder' => '排序',
            'display' => '隐藏',
        ];
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getRolePriv()
    {
        return $this->hasOne(RolePriv::className(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['id' => 'role_id'])->viaTable('role_priv', ['menu_id' => 'id']);
    }


    public function beforeDelete()
    {
        if (!parent::beforeDelete()) return false;
        if (self::find()->where(['parentid' => $this->id])->count())
        {
            return false;
        }
        return true;
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
            ->orderBy('id DESC')
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
        // print_r($array);
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
