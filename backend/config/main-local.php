<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '03lrf70HxJ99-Ftdt05ZzZRqGmLGQxvP',
        ],
    ],
//    'language'   => 'zh', // zh => 中文,  en => English
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

// zh_CN.UTF-8 => 中文,  en_US.UTF-8 => English
setlocale(LC_ALL, 'zh_CN.UTF-8');
putenv('LC_ALL=zh_CN.UTF-8');

return $config;
