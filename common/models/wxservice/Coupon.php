<?php
/**
 * 优惠券模型
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2017/05/11 16:23
 * @since    1.0
 */

namespace common\models\wxservice;

use Yii;
use backend\modules\admin\models\User;
class Coupon extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'hygl_coupon';
    }

    public function rules()
    {
        return [
            [['coupon_guid', 'title', 'depict', 'mp_type'], 'string'],
            [['title'], 'required'],
            ['price', 'integer', 'min'=>1, 'max'=>100000000],
            [['coupon_id', 'insert_time', 'insert_id', 'modify_time', 'modify_id', 'status'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'coupon_id' => '编号',
            'coupon_guid' => 'GUID编号',
            'mp_type' => '授权公号',
            'title' => '名称',
            'depict' => '描述',
            'price' => '价值',
            'status' => '启用',
            'insert_time' => '添加时间',
            'insert_id' => '添加人',
            'modify_time' => '更新时间',
            'modify_id' => '修改人',
        ];
    }


    public function beforeSave($insert = NULL)
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

    public static function groupList()
    {
        $list = self::find()->asArray()->all();
        if (!$list) return [];
        $return = [];
        foreach ($list as $value)
        {
            $return[$value['group_id']] = $value['title'];
        }
        return $return;
    }

    public function getCouponLog()
    {
        return $this->hasMany(CouponLog::className(), ['coupon_id' => 'coupon_id']);
    }
}