<?php
/**
 * 基类
 *
 * @author   gongjt@xxcb.cn
 * @version  2015/9/15 14:33
 * @since    1.0
 */

namespace components;

use yii\helpers\VarDumper;
use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use components\helper\TFileHelper;

class XyXy
{

    public static function getApp()
    {
        return \Yii::$app;
    }

    public static function getView()
    {
        $view = \Yii::$app->getView();
        return $view;
    }

    public static function getRequest()
    {
        return \Yii::$app->request;
    }

    public static function getResponse()
    {
        return \Yii::$app->response;
    }

    public static function getBaseUrl($url = null)
    {
        $baseUrl = \Yii::$app->request->getBaseUrl();
        if ($url !== null)
        {
            $baseUrl .= $url;
        }
        return $baseUrl;
    }

    public static function getHomeUrl($url = null)
    {
        $homeUrl = \Yii::$app->getHomeUrl();
        if ($url !== null)
        {
            $homeUrl .= $url;
        }
        return $homeUrl;
    }

    public static function getWebUrl($url = null)
    {
        $webUrl = \Yii::getAlias('@web');
        if ($url !== null)
        {
            $webUrl .= $url;
        }
        return $webUrl;
    }

    //前台url
    public static function getFrontendWebUrl($url = null)
    {
        if (YII_ENV_DEV)
        {
            return 'http://wxs.xxcb.dev/';
        }
        if (YII_ENV_TEST)
        {
            return 'http://wxs.xxcb.test/';
        }
        return 'http://plus2.senhua.net/';
    }


    public static function getWebPath($path = null)
    {
        $webPath = \Yii::getAlias('@webroot');
        if ($path !== null)
        {
            $webPath .= $path;
        }
        return $webPath;
    }

    public static function getAppParam($key, $defaultValue = null)
    {

        $params = \Yii::$app->params;
        if (array_key_exists($key, $params))
        {
            return $params[$key];
        }
        return $defaultValue;
    }

    public static function setAppParam($array)
    {
        foreach ($array as $key => $value)
        {
            \Yii::$app->params[$key] = $value;
        }
    }

    public static function getViewParam($key, $defaultValue = null)
    {
        $view = \Yii::$app->getView();
        if (isset($view->params[$key]))
        {
            return $view->params[$key];
        }
        return $defaultValue;
    }

    public static function setViewParam($array)
    {
        $view = \Yii::$app->getView();
        foreach ($array as $name => $value)
        {
            $view->params[$name] = $value;
        }
    }

    public static function hasGetValue($key)
    {
        return isset($_GET[$key]);
    }

    public static function getGetValue($key, $default = NULL)
    {
        if (self::hasGetValue($key))
        {
            return $_GET[$key];
        }
        return $default;
    }

    public static function hasPostValue($key)
    {
        return isset($_POST[$key]);
    }

    public static function getPostValue($key, $default = NULL)
    {
        if (self::hasPostValue($key))
        {
            return $_POST[$key];
        }
        return $default;
    }

    public static function setFalsh($type, $message)
    {
        \Yii::$app->session->setFlash($type, $message);
    }

    public static function setWarningMessage($message)
    {
        \Yii::$app->session->setFlash('warning', $message);
    }

    public static function setSuccessMessage($message)
    {
        \Yii::$app->session->setFlash('success', $message);
    }

    public static function setErrorMessage($message)
    {
        \Yii::$app->session->setFlash('error', $message);
    }

    public static function info($var, $category = 'application')
    {
        $dump = VarDumper::dumpAsString($var);
        Yii::info($dump, $category);
    }

    public static function getUser()
    {
        return Yii::$app->user;
    }

    public static function getIdentity()
    {
        return Yii::$app->user->getIdentity();
    }

    public static function getIsGuest()
    {
        return Yii::$app->user->isGuest;
    }

    public static function checkIsGuest($loginUrl = null)
    {
        $isGuest = Yii::$app->user->isGuest;
        if ($isGuest)
        {
            if ($loginUrl == false)
            {
                return false;
            }
            if ($loginUrl == null)
            {
                $loginUrl = ['site/login'];
            }
            return Yii::$app->getResponse()->redirect(Url::to($loginUrl), 302);
        }
        return true;
    }

    public static function checkAuth($permissionName, $params = [], $allowCaching = true)
    {
        $user = Yii::$app->user;
        return $user->can($permissionName, $params, $allowCaching);
    }

    public static function getDB()
    {
        return \Yii::$app->db;
    }

    public static function createCommand($sql = null)
    {
        $db = \Yii::$app->db;
        if ($sql !== null)
        {
            return $db->createCommand($sql);
        }
        return $db->createCommand();
    }

    public static function execute($sql)
    {
        $db = \Yii::$app->db;
        $command = $db->createCommand($sql);
        return $command->execute();
    }

    public static function queryAll($sql)
    {
        $db = \Yii::$app->db;
        $command = $db->createCommand($sql);
        return $command->queryAll();
    }

    public static function queryOne($sql)
    {
        $db = \Yii::$app->db;
        $command = $db->createCommand($sql);
        return $command->queryOne();
    }

    public static function getPagedRows($query, $config = [])
    {
        $countQuery = clone $query;
        $count = $countQuery->count();
        $pages = new Pagination(['totalCount' => $count]);

        if (isset($config['page']))
        {
            $pages->setPage($config['page'], false);
        }

        if (isset($config['pageSize']))
        {
            $pages->setPageSize($config['pageSize'], true);
        }

        $rows = $query->offset($pages->offset)->limit($pages->limit);


        if (isset($config['order']))
        {
            $rows = $rows->orderBy($config['order']);
        }

        $rows = $rows->all();


        $rowsLable = 'rows';
        $pagesLable = 'pages';

        if (isset($config['rows']))
        {
            $rowsLable = $config['rows'];
        }
        if (isset($config['pages']))
        {
            $pagesLable = $config['pages'];
        }

        $allNum = 0;
        //总共页数
        if($count > 0 && $config['pageSize'] > 0)
            $allNum = (int)($count / $config['pageSize']);



        //返回
        $ret = [];
        $ret[$rowsLable] = $rows;
        $ret[$pagesLable] = $pages;
        $ret['allNum'] = $allNum;
        return $ret;
    }
    
    /* url重写 */
    
    public static function rewriteurl($content)
    {
    	$rule = array();
    	$rule=self::loadrewriterule();
    	foreach ($rule as $s)
    	{
    		$content = preg_replace($s[0], $s[1], $content);
    	}
    	return $content;
    }
    
    /* 加载重写规则 */
    
    private static function loadrewriterule()
    {
    	$rule=array();
    	//后台生成到前台，实际上分页路径是后台的url路径，所以要换
    	$rule[] = array('/\/cms\/post\/create.html\?id=(\d+)&amp\;page=1/', '/post/$1.html');
    	$rule[] = array('/\/cms\/post\/create.html\?id=(\d+)&amp\;page=(\d+)/', '/post/$1-$2.html');
    	 
    	$rule[] = array('/\/cms\/post\/update.html\?id=(\d+)&amp\;page=1/', '/post/$1.html');
    	$rule[] = array('/\/cms\/post\/update.html\?id=(\d+)&amp\;page=(\d+)/', '/post/$1-$2.html');

    	//$rule[] = array('/\/(\w+)\/show.html\?id=(\d+)&page=(\d+)/', '/$1/$2-$3.html');
    	//$rule[] = array('/\/(\w+)\/show.html\?id=(\d+)/', '/$1/$2.html');
    	return $rule;
    }

    /**
     * @Desc: 打印数据
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $arr
     * @param int $exit
     */
    public static function dump($arr, $exit = 1)
    {
        echo '<pre>';
        print_r($arr);
        $exit && exit();
    }

    /**
     * @Desc: 记录日志
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $arr
     * @param string $file
     */
    public static function log($arr, $file = 'log')
    {
        error_log(var_export($arr, true), 3, \Yii::$app->basePath . '/runtime/logs/' . $file . '_' . date('Ymd') . '.log');
    }

    public static function getEnv($cn=false)
    {
        $str = $cn ? 'cn' : 'com';
        if (YII_ENV_DEV)
        {
            $str = 'dev';
        }
        if (YII_ENV_TEST)
        {
            $str = 'test';
        }
        return $str;
    }

    /**
     * @Desc: 用于到处csv数据
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $filename
     * @param $data
     */
    public static function export_csv($filename, $data)
    {
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $data;
        die;
    }

    public static function getUploadWebUrl()
    {
        $str = 'cn';
        if (YII_ENV_DEV)
        {
            $str = 'dev';
        }
        if (YII_ENV_TEST)
        {
            $str = 'test';
        }
        return 'http://f3.xxcb.' . $str . '/';
    }

    public static function formatAvatar($pic)
    {
        return '/upload/avatars/' . $pic;
    }

    /**
     * @Desc: 将对象转换成数组，主要用于关联表的情况。重名字段将被覆盖
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $model
     * @param array $related_table
     * @return array
     */
    public static function objectToArr($model, $related_table = [])
    {
        $arr = [];
        foreach ($model as $k => $v)
        {
            foreach ($v->attributes as $key => $val)
            {
                if ($val !== null) $arr[$k][$key] = $val;
            }
    
            if ($related_table)
            {
                foreach ($related_table as $rt)
                {
                    foreach ($v->$rt as $key => $val)
                    {
                        if ($val !== null) $arr[$k][$key] = $val;
                    }
                }
            }
        }
        return $arr;
    }

    /**
     * 返回ip库文件地址
     */
    public static function getIpdb()
    {
        return __DIR__ . '/../data/file/ip2region.db';
    }

    /**
     * 判断指定IP 是否在一个IP段里
     * $ip     指定IP
     * $net    IP段  例：192.168.1.255/24
     */
    public static function ipInNetwork($ip, $network)
    {
        $ip = (double) (sprintf("%u", ip2long($ip)));
        $s = explode('/', $network);
        $network_start = (double) (sprintf("%u", ip2long($s[0])));
        $network_len = pow(2, 32 - $s[1]);
        $network_end = $network_start + $network_len - 1;

        if ($ip >= $network_start && $ip <= $network_end)
        {
            return true;
        }
        return false;
    }

    public static function getIp()
    {
////        return Yii::$app->request->userIP;
//        $unknown = 'unknown';
////        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
////                && $_SERVER['HTTP_X_FORWARDED_FOR']
////                && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown))
////        {
////            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
////        }
////        else
//            if (isset($_SERVER['REMOTE_ADDR'])
//                && $_SERVER['REMOTE_ADDR']
//                && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown))
//        {
//            $ip = $_SERVER['REMOTE_ADDR'];
//        }
//        /*
//        处理多层代理的情况
//        或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
//        */
//        if (false !== strpos($ip, ','))
//            $ip = reset(explode(',', $ip));
//            XyXy::log($ip."\n", 'ipinfo.log');
//        return $ip;

        //获取真实ip
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos)
            {
                unset($arr[$pos]);
            }
            $ip = trim(current($arr));
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (isset($_SERVER['REMOTE_ADDR']))
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}



