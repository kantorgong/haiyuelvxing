<?php
/**
 * 优惠券日志模型
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2017/05/11 16:23
 * @since    1.0
 */

namespace common\models\wxservice;

use Yii;
use backend\modules\admin\models\User;
class CouponLog extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'hygl_coupon_log';
    }

    public function rules()
    {
        return [
            [['ip', 'open_id', 'nickname', 'depict'], 'string'],
            [['insert_time', 'userid', 'coupon_id', 'status'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'coupon_id' => '优惠券编号',
            'userid' => '用户编号',
            'open_id' => 'OPENID',
            'nickname' => '微信昵称',
            'title' => '名称',
            'status' => '是否领取',
            'ip' => 'ip',
            'insert_time' => '添加时间',
            'operat_time' => '操作时间',
            'operator_id' => '操作人',
            'depict' => '操作描述',
        ];
    }


    public function beforeSave($insert = NULL)
    {
        if ($this->isNewRecord)
        {
            $this->insert_time = time();
            $this->operat_time = 0;
        }
        else
        {
//            $this->operator_id = Yii::$app->user->identity->id;
            $this->operat_time = time();
        }
        return true;
    }



    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['coupon_id' => 'coupon_id']);
    }



}