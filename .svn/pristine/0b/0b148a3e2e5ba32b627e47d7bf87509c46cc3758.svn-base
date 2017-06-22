<?php
/**
 * 名称
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2016/11/22 19:52
 * @since    1.0
 */

namespace common\models\wxplus;

use Yii;
use backend\modules\admin\models\User;

class Activegroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lottery_active_group';
    }

    public function rules()
    {
        return [
            [['group_id', 'title', 'depict'], 'string'],
            [['title'], 'required'],
            [['id', 'insert_time', 'insert_id', 'modify_time', 'modify_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'group_id' => 'guid',
            'title' => '活动分组',
            'depict' => '描述',
            'insert_time' => '添加时间',
            'insert_id' => '添加人',
            'modify_time' => '更新时间',
            'modify_id' => '修改人',
        ];
    }


    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->insert_id = Yii::$app->user->identity->id;
            $this->insert_time = time();
            $this->modify_time = 0;
        }
        else
        {
            $this->modify_id = Yii::$app->user->identity->id;
            $this->modify_time = time();
        }
        return true;
    }

    public function getInsertor()
    {
        return $this->hasOne(User::className(), ['id' => 'insert_id'])->select('name');
    }

    public function getModifior()
    {
        return $this->hasOne(User::className(), ['id' => 'modify_id'])->select('name');
    }
}