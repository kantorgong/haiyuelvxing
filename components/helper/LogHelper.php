<?php
namespace components\helper;
use Yii;
class LogHelper
{
    /**
     * 错误日志输出
     * message:输出错误消息
     * categories：错误类型
     * data:输出错误数据
     */
    public static function error($message, $categories='error', $data=null)
    {
        if (is_array($data) || is_object($data))
        {
            $message .= '数据：' . var_export($data,true);
        }
        Yii::error($message, $categories);
    }

    /**
     * 警告日志输出
     */
    public static function warning($message, $categories='warning', $data=null)
    {
        if (is_array($data) || is_object($data))
        {
            $message .= '数据：' . var_export($data,true);
        }
        Yii::warning($message, $categories);
    }

    /**
     * 提示日志输出
     */
    public static function info($message, $categories='info', $data=null)
    {
        if (is_array($data) || is_object($data))
        {
            $message .= '数据：' . var_export($data,true);
        }
        Yii::info($message, $categories);
    }

    /**
     * 调试输出
     */
    public static function trace($message, $categories='trace',$data=null)
    {
        if (is_array($data) || is_object($data))
        {
            $message .= '数据：' . var_export($data,true);
        }
        Yii::trace($message, $categories);
    }
}
