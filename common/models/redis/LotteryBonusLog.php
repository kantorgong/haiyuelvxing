<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class LotteryBonusLog extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'return_code', 'return_msg', 'result_code',
                'err_code', 'err_code_des', 'mch_billno', 'mch_id', 'wxappid', 're_openid', 'total_amount'];
    }
}
