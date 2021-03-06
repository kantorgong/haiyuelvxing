<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use components\XyXy;
use components\helper\CommonUtility;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ThemeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/main-new.css',
//        'css/page.css',
//        'css/swiper.min.css',
    ];
    public $js = [
    ];
    public $depends = [
        
    ];
    
    public function init()
    {
    	$this->baseUrl='/static/themes/'.CommonUtility::getCurrentTheme();
    	parent::init();
    }
}
