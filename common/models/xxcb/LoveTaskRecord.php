<?php

namespace common\models\xxcb;

use Yii;

/**
 * This is the model class for table "love_task_record".
 *
 * @property integer $rid
 * @property string $uid
 * @property integer $day
 * @property integer $no
 * @property string $image
 * @property string $remark
 * @property integer $insert_time
 */
class LoveTaskRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'love_task_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'no', 'uid'], 'integer'],
            [['image', 'remark'], 'string', 'max' => 200],
            [['insert_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => 'ID',
            'uid' => '用户ID',
            'day' => '第几天',
            'no' => 'No',
            'image' => '图片',
            'remark' => '文字',
            'insert_time' => '添加时间',
        ];
    }

    public function beforeSave($insert = NULL)
    {
        if($this->isNewRecord)
        {
            $this->insert_time = time();
        }
        return true;
    }

    public function getNickname()
    {
        return $this->hasOne(LoveUser::className(), ['uid'=>'uid'])->select('nickname');
    }
}
