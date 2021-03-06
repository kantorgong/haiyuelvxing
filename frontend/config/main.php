<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => '微信服务云',
    'basePath' => dirname(__DIR__),
	//语言 i18n配置，可以设置语言包
    'language' => 'zh-CN',
//    'bootstrap' => ['log'],
    'bootstrap' => ['debug'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ]
    ],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'wechat' => [
            'class'=> 'frontend\modules\wechat\ModuleWechat',
        ],
        'activity' => [
                'class'=> 'frontend\modules\activity\ModuleActivity',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'frontend\modules\member\models\Member',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error','warning'],
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'class' => 'frontend\base\BaseFrontView',
        ],

         //url管理、美化
         'urlManager' => [
//            'class' => 'yii\web\UrlManager',
 //            //扩展名
             'suffix' => '.html',
             // Disable r= routes
             'enablePrettyUrl' => true,
             // 弃用（不使用）index.php
             'showScriptName' => false,
             // 'enableStrictParsing' => true,
             'rules' => include_once(__DIR__.'/rules.php'),
         ],
        //缓存
        'cache'=>[
            'class'=>'yii\caching\FileCache',
            //缓存文件存放在runtime文件夹中
            'directoryLevel'=>'2',   //缓存文件的目录深度
        ],
    ],

    'params' => $params,
];
