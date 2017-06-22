<?php
/**
 * 权限菜单类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/23 22:01
 * @since    1.0
 */

namespace backend\modules\admin\models;


class RolePriv extends \backend\modules\admin\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_role_priv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'menu_id'], 'required'],
            [['role_id', 'menu_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => '角色ID',
            'menu_id' => '菜单ID',
        ];
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id'])->viaTable('admin_role_priv', ['role_id' => 'id']);
    }
}
