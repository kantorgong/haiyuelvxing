<?php
/**
 * 后台路由规则
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/25 18:43
 * @since    1.0
 */
return [
    //访问根目录指向到后台首页
    '/' => '/admin/default/index',
    //后台首页
    [
        'pattern' => '/admin',
        'route' => '/admin/default/index',
    ],
    //gii模块
    [
        'pattern' => '/gii/<controller:\w+>/<action:\w+>',
        'route' => '/gii/<controller>/<action>',
    ],
    //admin模块
    [
        'pattern' => '/admin/<controller:\w+>/<action:\w+>',
        'route' => '/admin/<controller>/<action>',
    ]
];