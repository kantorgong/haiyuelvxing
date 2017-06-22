<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class LotteryLog extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'act_id', 'open_id', 'times', 'share', 'praise'];
    }
}
