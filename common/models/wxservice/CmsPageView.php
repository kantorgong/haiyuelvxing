<?php

namespace common\models\wxservice;

use Yii;
use yii\db\ActiveRecord;
use backend\modules\admin\models\User;

class CmsPageView extends ActiveRecord
{

    public static function tableName()
    {
        return 'cms_page_view';
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'guid' => '标识符',
            'title' => '页面标题',
            'link' => '页面链接',
            'view' => '实际访问数',
            'show' => '展示访问数',
            'insert_id' => '添加人编号',
            'insert_time' => '添加时间',
            'modify_id' => '修改人编号',
            'modify_time' => '修改时间',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['view', 'show'], 'integer']
        ];
    }

    public function beforeSave($insert = NULL)
    {
        if($this->isNewRecord)
        {
            $this->insert_id = Yii::$app->user->identity->id;
            $this->insert_time = time();
            $this->modify_time = 0;
            $this->guid = \components\helper\CommonUtility::createGuid();
        }
        else
        {
            $this->modify_id = Yii::$app->user->identity->id;
            $this->modify_time = time();
        }
        return true;
    }

    public function getInsertor()
    {
        return $this->hasOne(User::className(), ['id' => 'insert_id'])->select('name');
    }

    public function getModifior()
    {
        return $this->hasOne(User::className(), ['id' => 'modify_id'])->select('name');
    }

}
