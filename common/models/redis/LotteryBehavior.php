<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class LotteryBehavior extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'act_id', 'open_id', 'key', 'allow', 'duration',
                'coordinate', 'last_percent', 'token', 'init_time', 'last_time', 'last_x', 'last_y'];
    }
}
