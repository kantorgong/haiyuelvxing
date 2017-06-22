<?php

/**
 * @filename test.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-4-14 14:31:00
 * @version 1.0
 * @copyright (c) 2016-4-14, 潇湘晨报（版权）
 * @access public 权限
 */

function getMethodName($length = 32)
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = "";
    for ($i = 0; $i < $length; $i++)
    {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

$key = getMethodName();
$open_id = getMethodName();

$redis = new \Redis();
$redis->pconnect("10.0.7.64", 6379);
$redis->set($key, $open_id, 86400);
setcookie("wechatkey", "$key", time() + 86400);

?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>微信摇一摇测试</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript">
            function lottery()
            {
                $.post('http://xy.xxcb.test/activity/draw/lottery', {"gid":"55D6B8C1E0449C9933D6DC0C410A5417"}, function(ret)
                {
                    if(1 != ret.status)
                        alert(ret.error_msg);
                }, "json");
            }
        </script>
    </head>
    <body>
        <button onclick="lottery();">抽奖</button>
    </body>
</html>
