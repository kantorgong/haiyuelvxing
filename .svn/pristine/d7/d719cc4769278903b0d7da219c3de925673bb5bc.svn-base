<?php
$params = [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'wechat' => [
            'xxcb'      => [
                    'debug'     => true,
                    'app_id'    => 'wx6104ad130cf65c5c',
                    'secret'    => 'ec11fad93eed6610f2716eeb37980157',
                    'token'     => 'album_8888',
                    'oauth' => [
                            'callback' => '/wechat/oauth/callback.html',
                            'scopes'   => ['snsapi_userinfo'],
                    ],
                    'log' => [
                            'level' => 'debug',
                            //'file'  => '/data/winfile/zhujw/wechat.log',
                    ]
            ],
        '94uv'     =>[
            'debug'     => true,
            'app_id'    => 'wx2c4643a8a115af7f',
            'secret'    => '018d40ff2a5afcc315e146aa6756a29b',
            'token'     => 'album_8888',
            'oauth' => [
                'callback' => '/wechat/oauth/callback.html',
                'scopes'   => ['snsapi_userinfo'],
            ],
            'payment' => [
                'merchant_id'        => '10035717',
                'key'                => 'gAgLugeg2chP6H5l3aJfwCVwwtannhKd',
                'cert_path'          => '/data/wwwroot/data/wx_pay_certificate/apiclient_cert.pem',
                'key_path'           => '/data/wwwroot/data/wx_pay_certificate/apiclient_key.pem',
                // ...
            ],
            'log' => [
                'level' => 'debug',
                //'file'  => '/data/winfile/zhujw/wechat.log',
            ]
        ],

    ],
    // 小程序相关配置
    'wxApp' =>[
        'wyrl' =>[
            'appid' => 'wx8e3def7a011cc826',
            'secret' => '7bfe443cc09fa3e550ca749260bb1fe5',
        ],
    ],
];
$params = array_merge(
    $params,
    require(dirname(dirname(__DIR__)) . '/data/cache/cachedData.php')
);

return $params;
