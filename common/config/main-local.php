<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=10.0.7.66:6033;dbname=xzydb',
            'username' => 'root',
            'password' => 'devdbmysql',
            'charset' => 'utf8',
        ],
//        'dbxaap' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=10.0.7.66:6033;dbname=xaap',
//            'username' => 'root',
//            'password' => 'devdbmysql',
//            'charset' => 'utf8',
//        ],
//        'mongodb' => [
//            'class' => '\yii\mongodb\Connection',
//            'dsn' => 'mongodb://sa:sa@10.0.7.64:27017/xydb',
//        ],
        'gearman' => [
            'class' => 'shakura\yii2\gearman\GearmanComponent',
            'servers' => [
                ['host' => '10.0.7.64', 'port' => 4730],
            ],
            'user' => 'www-data',
            'jobs' => [
                'activity' => [
                    'class' => 'common\jobs\Activity'
                ],
                'bonus' => [
                        'class' => 'common\jobs\Bonus'
                ],
            ]
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '10.0.7.64',
            'port' => 6379,
            'database' => 0,
        ],
        'memcached' => [
            'class' => 'components\caching\MemCached',
            'useMemcached' => TRUE,
            'keyPrefix' => '',
            'serializer' => false,
            'servers' => [
                [
                    'host' => '10.0.7.64',
                    'port' => 11211,
                    'weight' => 60,
                ],
            ],
        ],
        'mailer' => [  
            'class' => 'yii\swiftmailer\Mailer', 
            'viewPath' => '@common/mail',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [  
                'class' => 'Swift_SmtpTransport',  
                'host'       => 'smtp.huamanshu.com',     # smtp 发件地址
                'username'   => 'service@huamanshu.com',  # smtp 发件用户名
                'password'   => 'K84erUuxg1bHqrfD',       # smtp 发件人的密码
                'port' => '25',  
                'encryption' => 'tls',  
            ],   
            'messageConfig'=>[  
                'charset'=>'UTF-8',  
                'from'  => ['service@huamanshu.com' => 'xy系统']
            ],  
         ],
        //微信开发组件，基于easywechat
        'wechat' => [
            'class' => 'maxwen\easywechat\Wechat',
        ],
    ],
    'controllerMap' => [
        'gearman' => [
            'class' => 'shakura\yii2\gearman\GearmanController',
            'gearmanComponent' => 'gearman'
        ]
    ]
];
