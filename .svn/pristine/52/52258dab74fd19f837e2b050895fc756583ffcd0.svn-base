<?php
/**
 * SchoolController
 * 作者: limj
 * 版本: 17-4-11
 */

namespace frontend\modules\activity\controllers;
use \Yii;
use common\models\activity\ExtCsxqf;

class SchoolController extends \frontend\modules\activity\components\Controller
{
    // 设置redis 键的前缀
    public $preKey = 'QWESCHOOL';

    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    public function actionSearch()
    {
        $type = intval(\Yii::$app->request->get('type'));
        if(empty($type)) $type = 1;
        $keyWords = \Yii::$app->request->get('keyWords');
        if(empty($keyWords))
        {
            return $this->redirect('index.html');
        }
        $md5Key = md5($keyWords);
        if($type == 1)
        {
            // 搜索小区
            $list = Yii::$app->redis->hget($this->__getKey('keyWords_1'), $md5Key);
            if(empty($list))
            {
                $list = ExtCsxqf::find()
                        ->where(['like', 'extent', $keyWords])
                        ->asArray()
                        ->orderBy('id ASC')
                        ->all();
                foreach($list as $key=>$value)
                {

                    $list[$key]['extent'] = str_replace($keyWords, "<span>{$keyWords}</span>",$value['extent']);
                    //$list[$key]['extent'] = str_replace('主要楼盘：', "<br /><br />主要楼盘：",$list[$key]['extent']);
                }
                Yii::$app->redis->hset($this->__getKey('keyWords_1'), $md5Key, \GuzzleHttp\json_encode($list));
            }
            else
            {
                $list = \GuzzleHttp\json_decode($list, true);
            }
        }
        else
        {
            // 搜索学校
            $list = Yii::$app->redis->hget($this->__getKey('keyWords_2'), $md5Key);
            if(empty($list))
            {
                $list = ExtCsxqf::find()
                    ->where(['like', 'school', $keyWords])
                    ->asArray()
                    ->orderBy('id ASC')
                    ->all();
                foreach($list as $key=>$value)
                {
                    $list[$key]['school'] = str_replace($keyWords, "<span>{$keyWords}</span>",$value['school']);
                    //$list[$key]['extent'] = str_replace('主要楼盘', "<br />主要楼盘",$list[$key]['extent']);
                }
                Yii::$app->redis->hset($this->__getKey('keyWords_2'), $md5Key, \GuzzleHttp\json_encode($list));
            }
            else
            {
                $list = json_decode($list, true);
            }
        }
        return $this->renderPartial('search',['list'=>$list,'keyWords'=>$keyWords]);
    }

    public function actionError()
    {
        return $this->renderPartial('404');
    }
    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }
}