<?php
/**
 * FlushController
 * 作者: limj
 * 版本: 17-3-28
 */

namespace console\controllers;
use yii;
use yii\console\Controller;

class FlushController extends Controller
{
    // 设置redis 键的前缀
    public $preKey = 'QWERTSF';

    /**
     * 描述：每天凌晨01:00 删除前一天没有刮卡的缓存
     */
    public function actionIndex()
    {
        Yii::$app->redis->del($this->__getKey('uAnswer_token'));
    }

    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }
} 