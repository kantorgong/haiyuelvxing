<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    //应用ID
    'id' => 'app-backend',
    'name' =>'微信应用管理系统',
    //语言 i18n配置，可以设置语言包
    'language' => 'zh-CN',
    //时区
    'timeZone' => 'Asia/Shanghai',
    //根目录
    'basePath' => dirname(__DIR__),
    //首页
    'homeUrl' => '/',
    //控制器命名空间
    'controllerNamespace' => 'backend\controllers',
    //bootstrap
    'bootstrap' => ['log'],
    //模块
    'modules' => [
        //管理员模块
        'admin' => [
            'class' => 'backend\modules\admin\ModuleAdmin',
            'superUserIds' => [1],
            'layout' => '@app/modules/admin/views/layouts/main.php',
        ],
        'grant' => [
            'class' => 'mdm\admin\Module',
            'layout' => '../../../../../backend/modules/admin/views/layouts/main.php',//设置布局文件,

        ],
        //发布系统模块
        'cms' => [
                'class' => 'backend\modules\cms\ModuleCms',
                'superUserIds' => [1]
        ],
        //微信活动
        'wxplus' => [
            'class' => 'backend\modules\wxplus\ModuleWxplus',
            'superUserIds' => [1]
        ],
        //微信服务
        'wxservice' => [
            'class' => 'backend\modules\wxservice\ModuleWxservice',
            'superUserIds' => [1]
        ],
        //服务系统模块
        'service' => [
                'class' => 'backend\modules\service\ModuleService',
                'superUserIds' => [38]
        ],
        'xxcb' => [
            'class' => 'backend\modules\xxcb\Module',
            'layout' => '@app/modules/admin/views/layouts/main.php',
        ],
        //debug
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1']
        ],
    ],
    //组件
    'components' => [
        //用户
        'user' => [
            'identityClass' => 'backend\modules\admin\models\User',
            'enableAutoLogin' => true,
            'loginUrl'=>['admin/default/login'],//定义后台默认登录界面[权限不足跳到该页]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                ]
            ]
        ],
        //格式化
        'formatter' => [
            //日期时间格式化
            'dateFormat' => 'yyyy-MM-dd',
            'timeFormat' => 'HH:mm:ss',
            'datetimeFormat' => 'yyyy-MM-dd,HH:mm:ss',
            //小数分隔符
            'decimalSeparator' => ',',
            //千位分隔符
            'thousandSeparator' => ' ',
            //货币代码
            'currencyCode' => 'EUR',
        ],
        //url管理、美化
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
//            //扩展名
            'suffix' => '.html',
            // Disable r= routes
            'enablePrettyUrl' => true,
            // 弃用（不使用）index.php
            'showScriptName' => false,
//            'enableStrictParsing' => true,
            'rules' => include_once(__DIR__.'/rules.php'),
        ],
        //前端资源管理
        'assetManager'=>[
            'bundles'=>[
                'yii\web\JqueryAsset'=>[
                    'jsOptions'=>[
                        'position'=>\yii\web\View::POS_HEAD,
                    ],
//                    'sourcePath'=>null,
//                    'js'=>[]
                ]
            ]
        ],
        //错误处理
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //后台试图基类
        'view' => [
            'class' => 'backend\components\web\BaseBackView',
        ],
        //国际化
        'i18n' => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                ],
            ],
        ],
        //自定义图片上传类
        'imgload' => [
            'class' => 'components\helper\Upload'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
        ],
        'as access' => [
            'class' => 'mdm\admin\components\AccessControl',
            'allowActions' => [
//            'admin/*',//允许所有人访问admin节点及其子节点
                'debug/*',
                'gii/*',
            ]
        ],
    ],
    'params' => $params,
];
