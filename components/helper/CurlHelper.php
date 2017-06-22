<?php
/**
 * @File: CurlHelpler.php
 * @User: zhujw <zhjw@xxcb.cn>
 * @Date: 2016/1/15 14:25
 * @Desc:
 */
namespace components\helper;

class CurlHelper
{
    private static $_timeout = 15;         //请求超时时间秒
    private static $_connect_timeout = 15; //连接超时时间秒

    /**
     * @Desc: get请求
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $url
     * @param array $curl_opt
     * @return mixed
     */
    public static function get($url, $curl_opt = [])
    {
        return self::_curl($url, [], $curl_opt);
    }

    /**
     * @Desc: post请求
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $url
     * @param $post
     * @param array $curl_opt
     * @return mixed
     */
    public static function post($url, $post, $curl_opt = [])
    {
        return self::_curl($url, $post, $curl_opt);
    }

    /**
     * @Desc: 封装的curl请求方法，支持自定义参数值
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $url
     * @param $post
     * @param $opt
     * @return mixed
     */
    private function _curl($url, $post, $opt)
    {
        //初始化参数
        $curl_opt = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FAILONERROR => false,
                CURLOPT_CONNECTTIMEOUT => self::$_connect_timeout,
                CURLOPT_TIMEOUT        => self::$_timeout,
                CURLOPT_SSL_VERIFYPEER => false,
        );

        //POST请求初始化POST数据
        if ($post)
        {
            $curl_opt[CURLOPT_POST] = true;
            $curl_opt[CURLOPT_POSTFIELDS] = $post;
        }

        //替换为用户自定义参数
        if ($opt)
        {
            foreach ($opt as $key => $val)
            {
                $curl_opt[$key] = $val;
            }
        }
        $ch = curl_init();
        curl_setopt_array($ch, $curl_opt);
        $return = curl_exec($ch);
        curl_close($ch);

        return $return;
    }
}