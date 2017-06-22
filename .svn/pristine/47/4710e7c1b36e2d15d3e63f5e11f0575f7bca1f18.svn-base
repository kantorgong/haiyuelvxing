<?php
/**
 * 时间处理工具类
 *
 * 格式化时间、返回输入的格式时间
 * @author   gongjt@xxcb.cn
 * @version  2015/9/15 14:33
 * @since    1.0
 */

namespace components\helper;

class TTimeHelper
{

    public static function getCurrentTime()
    {
        date_default_timezone_set('PRC');
        return date('Y-m-d H:i:s', time());
    }

    public static function showTime($time, $format = 'Y-m-d')
    {
        echo date($format, strtotime($time));
    }
}