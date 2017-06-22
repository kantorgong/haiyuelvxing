<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class LotteryLucky extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'act_id', 'bonus_amount'];
    }
}
