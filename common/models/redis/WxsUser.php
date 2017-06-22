<?php
namespace common\models\redis;

use Yii;
use \yii\redis\ActiveRecord;

class WxsUser extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'open_id', 'nickname', 'sex', 'province', 'country', 'headimgurl', 'union_id', 'city', 'from', 'insert_time'];
    }
}
