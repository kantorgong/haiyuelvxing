<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class LotteryPrize extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'act_id', 'name', 'content', 'bonus_amount',
                'probability', 'num_show', 'num', 'bonus_random', 'max_amount', 'min_amount',
                'bonus_amount_use', 'num_use'
        ];
    }
}
