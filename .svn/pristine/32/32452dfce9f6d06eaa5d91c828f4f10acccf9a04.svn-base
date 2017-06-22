<?php

/**
 * @filename MemCache.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-5-11 14:38:27
 * @version 1.0
 * @copyright (c) 2016-5-11, 潇湘晨报（版权）
 * @access public 权限
 */

namespace components\caching;

use Yii;
use yii\caching\MemCache;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use components\XyXy;
use components\helper\TTimeHelper;

class MemCached extends MemCache
{

    public function buildKey($key)
    {
        return $this->keyPrefix . $key;
    }

}
