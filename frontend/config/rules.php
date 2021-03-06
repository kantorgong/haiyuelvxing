<?php
/**
 * 前台路由规则
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/25 18:43
 * @since    1.0
 */
return [
    //访问根目录指向到后台首页
//    '/' => '/admin/default/index',

[
    'pattern' => '/debug/<controller:\w+>/<action:\w+>',
    'route' => '/debug/<controller>/<action>',
],
    //首页
    [
        'pattern' => '/',
        'route' => '/activity/lucky/index',
    ],
    //活动模块
    [
        'pattern' => '/activity/<controller:\w+>/<action:\w+>',
        'route' => '/activity/<controller>/<action>',
    ],
    //微信SDK模块
    [
        'pattern' => '/wechat/<controller:\w+>/<action:\w+>',
        'route' => '/wechat/<controller>/<action>',
    ]
];