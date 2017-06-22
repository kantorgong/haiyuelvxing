<?php

namespace common\models\wxservice;

use Yii;
use yii\db\ActiveRecord;

class LotteryBonusLog extends ActiveRecord
{

    public static function tableName()
    {
        return 'lottery_bonus_log';
    }

    public function rules()
    {
        return [
            [['return_code', 'return_msg', 'result_code', 'err_code', 'err_code_des', 'mch_billno', 'mch_id', 'wxappid', 're_openid', 'total_amount', 'insert_time'], 'safe'],
        ];
    }

}
