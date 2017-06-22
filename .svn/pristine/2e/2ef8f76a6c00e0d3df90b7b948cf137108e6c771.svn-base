<?php

/**
 * 贪吃蛇游戏日志记录
 */
namespace common\models\wxplus;

use Yii;
use components\db\BaseActiveRecord;

class CarSnakePlayLog extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_snake_play_log';
    }

    public function attributeLabels()
    {
        return [
                'id' => 'ID',
                'open_id' => '微信ID',
                'nickname' => '昵称',
                'header' => '头像',
                'total' => '总数',
                'server_last_time' => '服务端时长',
                'client_last_time' => '客户端时长',
                'score' => '得分',
                'start_time' => '开始时间',
                'insert_time' => '添加时间'
        ];
    }

    public function rules()
    {
        return [
            [['open_id'], 'required'],
            [['insert_time', 'id', 'start_time', 'server_last_time', 'client_last_time', 'total', 'score'], 'integer'],
            [['nickname', 'open_id', 'header', 'json_nickname', 'process', 'ip'], 'string'],
        ];
    }
}

?>