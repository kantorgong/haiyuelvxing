<?php

/**
 * @filename Acnews.php 
 * @encoding UTF-8 
 * @author tianxq 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-12-29 14:02:50
 * @version 1.0
 * @Description 官网app新闻信息模型类
 * @copyright (c) 2016-12-29, 潇湘晨报（版权）
 * @access public 权限
 */

namespace common\models\xaap;

use Yii;
use yii\db\ActiveRecord;
use components\db\BaseActiveRecord;
use yii\behaviors\BlameableBehavior;

class Acnews extends BaseActiveRecord
{
    public static function getDb() 
    {
        return Yii::$app->dbxaap;
    }
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ac_news';
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '信息编号'),
            'classid' => Yii::t('app', '栏目id'),
            'ecmsid' => Yii::t('app', '帝国信息ID'),
            'onclick' => Yii::t('app', '点击数'),
            'keyboard' => Yii::t('app', '关键字'),
            'keyid' => Yii::t('app', '相关链接信息ID'),
            'userid' => Yii::t('app', '发布者'),
            'username' => Yii::t('app', '发布者用户名'),
            'checked' => Yii::t('app', '是否审核'),
            'istop' => Yii::t('app', '置顶级别'),
            'truetime' => Yii::t('app', '真实发布时间'),
            'isgood' => Yii::t('app', '推荐级别'),
            'titleurl' => Yii::t('app', '链接地址'),
            'newstempid' => Yii::t('app', '内容模板ID'),
            'plnum' => Yii::t('app', '评论数'),
            'firsttitle' => Yii::t('app', '头条级别'),
            'title' => Yii::t('app', '标题'),
            'newstime' => Yii::t('app', '发布时间'),
            'ordertime' => Yii::t('app', '排序时间'),
            'ispic' => Yii::t('app', '发布时间'),
            'titlepic' => Yii::t('app', '是否标题图片'),
            'ftitle' => Yii::t('app', '副标题'),
            'isdelete' => Yii::t('app', '是否删除'),
            'smalltext' => Yii::t('app', '简介'),
            'datetype' => Yii::t('app', '数据类型'),
        ];
    }

    public function rules()
    {
        return [
            [['id', 'classid', 'ecmsid', 'onclick', 'userid', 'checked', 'istop', 'truetime', 'isgood', 
            'newstempid', 'plnum', 'newstime', 'ordertime', 'ispic', 'isdelete'], 'integer'],
            [['keyboard', 'username', 'titleurl', 'keyid', 'firsttitle', 'title', 'titlepic', 'ftitle', 
            'smalltext', 'datetype'], 'string'],
        ];
    }

}

?>