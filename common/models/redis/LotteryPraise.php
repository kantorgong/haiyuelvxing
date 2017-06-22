<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class LotteryPraise extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'act_id', 'praise'];
    }
}
