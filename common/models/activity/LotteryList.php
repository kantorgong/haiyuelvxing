<?php

namespace common\models\activity;

use Yii;
use yii\db\ActiveRecord;

class LotteryList extends ActiveRecord
{

    public static function tableName()
    {
        return 'lottery_list';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'guid' => 'guid',
            'group_id' => '活动分组',
            'type' => '抽奖形式',
            'act_name' => '活动名称',
            'attention' => '是否需要关注',
            'draw_num' => '每个微信号可抽奖多少次',
            'act_note' => '活动说明',
            'act_know' => '领奖须知',
            'status' => '活动状态',
            'share' => '是否支持分享',
            'share_add_num' => '分享之后添加抽奖次数',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'mp_type' => '授权公众号',
            'silence' => '是否静默授权',
            'bonus' => '是否红包抽奖',
            'bonus_share' => '是否分享后再发送红包',
            'bonus_send_name' => '红包发送人名称',
            'bonus_wishing' => '红包祝福语',
            'bonus_remark' => '红包备注',
            'bonus_random' => '是否随机红包',
            'bonus_amount' => '红包总额(分)',
            'max_amount' => '红包最大金额(分)',
            'min_amount' => '红包最小金额(分)',
            'probability' => '随机红包中奖概率(‱)',
            'insert_id' => '添加人编号',
            'insert_time' => '添加时间',
            'modify_id' => '修改人编号',
            'modify_time' => '修改时间',
            'global_rule' => '是否开启全局规则',
            'behavior' => '行为时长(ms)',
            'refuse' => '直接拒绝(%)',
            'black' => '黑名单',
            'white' => '白名单',
            'region' => '地区限制'
        ];
    }

    public function rules()
    {
        return [
            [['guid', 'type', 'act_name', 'draw_num', 'status', 'share', 'mp_type', 'silence', 'group_id'], 'required'],
            [['id', 'type', 'attention', 'draw_num', 'status', 'share', 'draw_num', 'share_add_num',
                    'insert_id', 'insert_time', 'modify_id', 'modify_time',
                    'mp_type', 'silence', 'bonus', 'bonus_share', 'bonus_random', 'bonus_amount',
                    'max_amount', 'min_amount', 'probability', 'global_rule', 'behavior', 'refuse'], 'integer'],
            [['act_name', 'act_note', 'act_know', 'guid', 'bonus_send_name', 'bonus_wishing', 'bonus_remark'], 'string'],
            [['start_time', 'end_time', 'black', 'white', 'region'], 'safe'],
            [['probability'], 'integer', 'max' => 10000]
        ];
    }

    public function beforeSave()
    {
        if($this->isNewRecord)
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
        $this->start_time && $this->start_time = strtotime($this->start_time);
        $this->end_time && $this->end_time = strtotime($this->end_time);
        $this->refuse = $this->refuse ? $this->refuse : 0;
        $this->behavior = $this->behavior ? $this->behavior : 0;
        return true;
    }

    public function getGroup()
    {
        return $this->hasOne(LotteryActiveGroup::className(), ['group_id' => 'group_id'])->select('title');
    }

    //奖品
    public function getLotteryWinner()
    {
        return $this->hasMany(LotteryWinner::className(), ['id' => 'act_id']);
    }

}
