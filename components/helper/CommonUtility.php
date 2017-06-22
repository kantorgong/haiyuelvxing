<?php
/**
 * 通用工具
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/28 16:55
 * @since    1.0
 */

namespace components\helper;


//use app\common\models\ContentFlag;
use common\models\Dict;
use common\models\DictCategory;
use yii\web\UploadedFile;
use components\XyXy;
use components\helper\TFileHelper;
use common\models\config\Config;
use yii\base\InvalidParamException;
use yii;

class CommonUtility
{

    public static function getYesNo($var = null)
    {
        $ret = ['1' => '是', '0' => '否'];
        if($var !== null)
        {
            return $ret[$var];
        }
        return $ret;
    }

    public static function getDataType($id = null)
    {
        $dataType = ['0' => '字符串', '1' => '数字', '2' => '布尔型', '3' => '日期', '4' => '数组', '5' => 'JSON'];

        if($id !== null)
        {
            return $dataType[$id];
        }

        return $dataType;
    }

    public static function getStatus($id = null)
    {
        $status = ['1' => '通过', '0' => '审核'];

        if($id !== null)
        {
            return $status[$id];
        }

        return $status;
    }

    public static function getTitleFormat($id = null)
    {
        $format = ['b' => '加粗', 'i' => '斜体', 'u' => '下划线', 's' => '删除线'];

        if($id !== null)
        {
            return $format[$id];
        }
        return $format;
    }

    public static function getTitleFormatValue($array)
    {
        if($array === null || ! is_array($array))
        {
            return '';
        }
        return implode(',', $array);
    }

    public static function getTitleFormatArray($var)
    {
        $format = '';
        if(is_string($var))
        {
            $format = $var;
        }
        else if(isset($var['title_format']))
        {
            $format = $var['title_format'];
        }

        return explode(',', trim($format, ','));
    }

    public static function formatTitle($title, $format)
    {
        $format = self::getTitleFormatArray($format);
        if(isset($format['b']))
        {
            $title = '<b>' . $title . '</b>';
        }
        if(isset($format['i']))
        {
            $title = '<i>' . $title . '</i>';
        }
        if(isset($format['u']))
        {
            $title = '<u>' . $title . '</u>';
        }
        if(isset($format['s']))
        {
            $title = '<s>' . $title . '</s>';
        }
// 		if(isset($format['c']))
// 		{
// 			$title = '<font color=' . $format['c'] . '>' . $title . '</font>';
// 		}
        return $title;
    }


    public static function getFlagValue($var)
    {
        if(is_string($var))
        {
            $var = explode(',', $var);
        }
        if(! is_array($var))
        {
            return 0;
        }

        $ret = 0;
        foreach($var as $value)
        {
            $ret += intval($value);
        }
        return $ret;
    }

    public static function getTitlePic($var)
    {
        $titlePic = '';
        if(is_string($var))
        {
            $titlePic = $var;
        }
        else if(isset($var['thumbnail']))
        {
            $titlePic = $var['thumbnail'];
        }
        if(stripos($titlePic, 'http') === false)
        {
            return $titlePic;
        }
        return $titlePic;
    }

    // 碎片类型
    public static function getFragmentType($id = null)
    {
        $ret = ['1' => '代码碎片', '2' => '静态碎片', '3' => '动态碎片'];
        if($id !== null)
        {
            if(isset($ret[$id]))
            {
                return $ret[$id];
            }
            return '';
        }
        return $ret;
    }

    public static function uploadFile($name)
    {
        $uploadedFile = UploadedFile::getInstanceByName($name);

        if($uploadedFile === null || $uploadedFile->hasError)
        {
            return null;
        }

        $ymd = date("Ymd");

        $save_path = \Yii::getAlias('@data/attachment/image_test') . '/' . $ymd . "/";
        $save_url = 'attachment/image/' . $ymd . "/";

        if(! file_exists($save_path))
        {
            mkdir($save_path);
        }

        $file_name = $uploadedFile->getBaseName();
        $file_ext = $uploadedFile->getExtension();

        // 新文件名
        $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;

        $uploadedFile->saveAs($save_path . $new_file_name);

        return ['path' => $save_path, 'url' => $save_url, 'name' => $file_name, 'new_name' => $new_file_name, 'ext' => $file_ext];
    }

    private static $currentTheme = null;

    public static function getCurrentTheme()
    {
        if(self::$currentTheme == null)
        {
            // todo
            self::$currentTheme = 'default';
        }
        return self::$currentTheme;
    }

    public static function getThemeUrl($resource = null)
    {
        $currentTheme = self::getCurrentTheme();

        if($resource === null)
        {
            return XyXy::getWebUrl() . '/static/themes/' . $currentTheme . '/';
        }
        return XyXy::getWebUrl() . '/static/themes/' . $currentTheme . '/' . $resource;
    }

    public static function getThemePath($path = null)
    {
        $currentTheme = self::getCurrentTheme();

        $frontend = \Yii::getAlias('@frontend');

        if(is_array($path))
        {
            $dir = array_merge([$frontend, 'themes', $currentTheme], $path);
        }
        else if(is_string($path))
        {
            $dir = [$frontend, 'themes', $currentTheme, $path];
        }
        else
        {
            $dir = [$frontend, 'themes', $currentTheme];
        }

        return TFileHelper::buildPath($dir);
    }

    public static function getFrontViews($dir, $prefix)
    {
        $themePath = self::getThemePath($dir);

        return TFileHelper::getFiles($themePath, $prefix);
    }

    public static function getBackViews($dir=null, $prefix=null)
    {
        $backend = \Yii::getAlias('@backend');
        if($dir==null)
        {
            $pathArray = [$backend, 'views'];
        }
        else
        {
            if(is_string($dir))
            {
                $pathArray = [$backend, 'views', $dir];
            }
            else if(is_array($dir))
            {
                $pathArray = array_merge([$backend, 'views'], $dir);
            }
        }
        return TFileHelper::getFiles($pathArray, $prefix);
    }

    public static function getFiles($dir = null, $prefix = null, $isBack = null)
    {
        $root = '';
        if($isBack === null)
        {
            $root = \Yii::getAlias('@webroot');
        }
        else if($isBack)
        {
            $root = \Yii::getAlias('@backend');
        }
        else
        {
            $root = \Yii::getAlias('@frontend');
        }

        if($dir !== null)
        {
            if(is_string($dir))
            {
                $pathArray = [$root, $dir];
            }
            else if(is_array($dir))
            {
                $pathArray = array_merge([$root], $dir);
            }
        }
        else
        {
            $pathArray=[$root];
        }

        return TFileHelper::getFiles($pathArray, $prefix);
    }

    public static function getAttachUrl($url, $echo = true)
    {
        if($echo)
        {
            echo XyXy::getWebUrl() . '/data/attachment/' . $url;
        }
        return XyXy::getWebUrl() . '/data/attachment/' . $url;
    }

    public static function getCachedValue($cache, $id = null, $defaultValue = null)
    {
        $cacheItem = XyXy::getAppParam($cache);
        if($cacheItem === null)
        {
            throw new InvalidParamException('cache key:' . $cache . ' does not exist');
        }

        if($id === null)
        {
            return $cacheItem;
        }
        if(isset($cacheItem[$id]))
        {
            return $cacheItem[$id];
        }
        return $defaultValue;
    }

    public static function getConfig($id=null)
    {
        $cached = XyXy::getAppParam('cachedConfigs');
        if($id!==null)
        {
            return $cached[$id];
        }
        return $cached;
    }

    public static function getConfigValue($id)
    {
        $cached = XyXy::getAppParam('cachedConfigs');
        return $cached[$id]['value'];
    }

    public static function getChannels($id = null)
    {
        $cachedChannels = XyXy::getAppParam('cachedChannels');
        if($id !== null)
        {
            return $cachedChannels[$id];
        }
        return $cachedChannels;
    }


    public static function getVariable($id=null)
    {
        $cached = XyXy::getAppParam('cachedVariables');
        if($id!==null)
        {
            return $cached[$id];
        }
        return $cached;
    }

    public static function getVariableValue($id)
    {
        $cached = XyXy::getAppParam('cachedVariables');
        $dataType=$cached[$id]['data_type'];
        //$dataType = ['0' => '字符串', '1' => '数字', '2' => '布尔型', '3' => '日期', '4' => '数组', '5' => 'JSON'];

        $value = $cached[$id]['value'];
        if($dataType===0)
        {
            return $value;
        }
        if($dataType===1)
        {
            return intval($value);
        }
        if($dataType===2)
        {
            $value = strtolower($value);
            if($value=='true'||$value=='1')
            {
                return true;
            }
            return false;
        }
        if($dataType===3)
        {
            return $value;
        }
        if($dataType===4)
        {
            return $value;
        }
        if($dataType===5)
        {
            return $value;
        }
        return $value;
    }

    public static function getDict($category,$id)
    {
        $cached = XyXy::getAppParam('cachedDicts');
        return $cached[$category][$id];
    }
    public static function getDicts($category,$pid)
    {
        $ret = [];
        $cached = XyXy::getAppParam('cachedDicts');
        $dicts = $cached[$category];
        if($pid===0)
        {
            foreach ($dicts as $id=>$dict)
            {
                if($dict['parent_id']===0)
                {
                    $ret[$id]=$dict;
                }
            }
        }
        else
        {
            $dict = $dicts[$pid];
            $childIds=explode(',', $dict['child_ids']);
            foreach ($childIds as $childId)
            {
                $ret[$childId]=$dicts[$childId];
            }
        }
        return $ret;
    }

    public static function getDictsList($category, $pid, $value =false)
    {
        $ret = [];
        $cached = XyXy::getAppParam('cachedDicts');
        $dicts = $cached[$category];
        if (!$dicts) return $ret;

        //如果以VALUE为键名
        if ($value)
        {
            foreach ($dicts as $dict)
            {
                $ret[$dict['value']] = $dict['name'];
            }
            return $ret;
        }

//        rsort($dicts);
        if ($pid === 0)
        {
            foreach ($dicts as $id=>$dict)
            {
                if($dict['parent_id']===0)
                {
                    $ret[$id]=$dict['name'];
                }
            }
        }
        else
        {
            $dict = $dicts[$pid];
            $childIds=explode(',', $dict['child_ids']);
            foreach ($childIds as $childId)
            {
                $ret[$childId]=$dicts[$childId]['name'];
            }
        }
        return $ret;
    }

    //获取数据字典路径
    public static function getDictPath($category, $pid)
    {
        $dictpath = [];
        if ($category != '')
        {
            $dictcategoryModle = new DictCategory();
            $dictpath['home'] = $dictcategoryModle->getDictCategory($category);
        }
        if ($pid > 0)
        {
            $dictModle = new Dict();
            $dictpath['other'] =$dictModle->getParents($pid);
        }
        return $dictpath;
    }

    //获取ip地址
    public static function  getIP() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

// 	private $_cachedRoles;

// 	public function getCachedRoles()
// 	{
// 		if($this->_cachedRoles == null)
// 		{
// 			$this->_cachedRoles = YiiForum::getAppParam('cachedRoles');
// 		}
// 		return $this->_cachedRoles;
// 	}

// 	private $_cachedRoleGroups;

// 	public function getCachedRoleGroups()
// 	{
// 		if($this->_cachedRoleGroups == null)
// 		{
// 			$this->_cachedRoleGroups = YiiForum::getAppParam('cachedRoleGroups');
// 		}
// 		return $this->_cachedRoleGroups;
// 	}

// 	private $_cachedPermissions;

// 	public function getCachedPermissions()
// 	{
// 		if($this->_cachedPermissions == null)
// 		{
// 			$this->_cachedPermissions = YiiForum::getAppParam('cachedPermissions');
// 		}
// 		return $this->_cachedPermissions;
// 	}

// 	private $_cachedPermissionCategories;

// 	public function getCachedPermissionCategories()
// 	{
// 		if($this->_cachedPermissionCategories == null)
// 		{
// 			$this->_cachedPermissionCategories = YiiForum::getAppParam('cachedPermissionCategories');
// 		}
// 		return $this->_cachedPermissionCategories;
// 	}



    public static function random($length, $numeric = 0) {
        $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
        if($numeric) {
            $hash = '';
        } else {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }
        $max = strlen($seed) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }

    public static function url_to_dir($url)
    {
        $dir_cur="";
        $str=$_SERVER["SERVER_SOFTWARE"];
        if(is_int(strpos($str,"pache"))===true){
            $dir_cur="/";
        }
        elseif(is_int(strpos($str,"IIS"))===true){
            $dir_cur="\\";
        }else{
            $dir_cur="/";
        }
        $url=str_replace("/",$dir_cur,$url);
        $url=$_SERVER['DOCUMENT_ROOT'].$url;
        return $url;
    }

    public static function unescape($str)
    {
        $ret = '';
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++){
            if ($str[$i] == '%' && $str[$i+1] == 'u'){
                $val = hexdec(substr($str, $i+2, 4));
                if ($val < 0x7f){
                    $ret .= chr($val);
                } else if($val < 0x800) {
                    $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f));
                } else{
                    $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f));
                }
                $i += 5;
            }
            else if ($str[$i] == '%'){
                $ret .= urldecode(substr($str, $i, 3));
                $i += 2;
            }else {
                $ret .= $str[$i];
            }
        }
        return $ret;
    }

    public static function formatTime($time)
    {
        $t = time() - $time;
        $f = array(
            '31536000' => Yii::t("app", 'Years'),
            '2592000' => Yii::t("app", 'Months'),
            '604800' => Yii::t("app", 'Weeks'),
            '86400' => Yii::t("app", 'Days'),
            '3600' => Yii::t("app", 'Hours'),
            '60' => Yii::t("app", 'Minutes'),
            '1' => Yii::t("app", 'Seconds')
        );
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                $m = floor($t % $k);
                foreach ($f as $x => $y) {
                    if (0 != $r = floor($m / (int)$x)) {
                        return $c.$v.$r.$y.Yii::t("app", 'ago');
                    }
                }
                return $c.$v.Yii::t("app", 'ago');
            }
        }
    }

    public static function tranTime($time)
    {
        $rtime = date("m-d H:i",$time);
        $htime = date("H:i",$time);
        $time = time() - $time;
        if ($time < 60)
        {
            $str = '刚刚';
        }elseif($time < 60 * 60){
            $min = floor($time/60);
            $str = $min.'分钟前';
        }elseif($time < 60 * 60 * 24){
            $h = floor($time/(60*60));
            $str = $h.'小时前 '.$htime;
        }elseif($time < 60 * 60 * 24 * 3){
            $d = floor($time/(60*60*24));
            if($d==1){
                $str = '昨天 '.$rtime;
            }else{
                $str = '前天 '.$rtime;
            }
        }else{
            $str = $rtime;
        }
        return $str;
    }


    /**
     * 生成GUID（UUID）
     * @access public
     * @return string
     * @author knight
     */
    public static function createGuid()
    {
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                ;// "}"
            return $uuid;
        }
    }

    /**
     * 描述：生成会话talk_id
     */
    public static function getTalkId($uid,$toUid)
    {
        $talkArr = array($uid, $toUid);
        sort($talkArr);
        return md5(implode(',', $talkArr));
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

    /**
     * 返回ip库文件地址
     */
    public static function getIpdb()
    {
        return __DIR__ . '/../../data/file/ip2region.db';
    }

}
