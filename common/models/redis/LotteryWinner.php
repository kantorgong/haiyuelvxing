<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class LotteryWinner extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'act_id', 'group_id', 'open_id', 'prize_id', 'complete',
                'share', 'name', 'phone', 'nickname', 'bonus_amount', 'billno', 'header', 'insert_time', 'get_time', 'is_fail'];
    }
}
