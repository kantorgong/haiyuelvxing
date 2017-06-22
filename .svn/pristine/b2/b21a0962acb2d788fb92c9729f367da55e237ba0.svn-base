<?php
namespace frontend\base;
/**
 * MYUV：xmen.mod.php
 * 模型基础类
 * 版本：2014-4-12
 */
class BaseXmenApi
{

    public $_system_param = array();
    public $_apply_param = NULL;
    public $_url = NULL;
    public $_charset = "utf-8";
    public $_version = "1.0";
    public $_method = NULL;
    public $_time = NULL;
    public $_data_type = "json";
    public $_app_id = NULL;
    public $_sign = NULL;
    public $_sign_text = NULL;
    public $_timeout = NULL;
    public $_sign_key = NULL;
    public $api_requet_info;
    public $api_requet_error;

    public function sendRequst($method, $params, $timeout = XMEN_API_TIME_OUT)
    {
        $this->_time = time();
        $this->_method = $method;
        $this->_timeout = $timeout;
        $this->_apply_param = json_encode($params);
        $this->_handleSystemParam();
        $return = $this->request();
       
        return json_decode($return, true);
    }

    private function _makeSystemParam()
    {
        $this->_system_param = array(
                "charset" => $this->_charset,
                "version" => $this->_version,
                "method" => $this->_method,
                "time" => $this->_time,
                "data_type" => $this->_data_type,
                "app_id" => $this->_app_id
        );
        ksort($this->_system_param);
    }

    private function _handleSystemParam()
    {
        $this->_makeSystemParam();

        $this->_sign_text = '';
        $this->_url = XMEN_API_URL . '?';
        $this->_system_param["app_id"] = XMEN_API_APP_ID;

        /* 处理系统参数 */
        foreach ($this->_system_param AS $k => $v)
        {
            $this->_sign_text .= "&{$k}={$v}";
            $this->_url .= "{$k}={$v}&";
        }

        $this->_sign_text .= $this->_apply_param . XMEN_API_SIGN_KEY;
        $this->makeSign();

        $this->_url .= 'sign=' . $this->_sign;
    }

    public function makeSign()
    {
        $this->_sign = strtolower(md5(substr($this->_sign_text, 1)));
    }

    public function request()
    {
        $ch = curl_init();
        $host = array('Host:' . XMEN_API_DOMAIN);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $host);
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_apply_param);

        $return = curl_exec($ch); //请求接口
        $this->api_requet_info = curl_getinfo($ch);
        $this->api_requet_error = curl_errno($ch);
        curl_close($ch); //关闭此句柄

        return $return;
    }

    /**
     * 第三方应用接口
     * @param $app_id 第三方应用ID
     * @param $app_func 方法名称
     * @param $params 其它参数
     * @author zhujw
     * @date 20150316
     * @return json 返回JSON字符串
     */
    public function sendThirdApiRequest($app_id, $app_func, $params = array())
    {
        //基础路由方法
        $method = 'xmen.thirdApi.baseThirdApi.apiRoute';
        //将ID和方法加入到参数中
        $params['third_app_id'] = $app_id;
        $params['third_app_func'] = $app_func;
        $params['session_id'] = session_id();
        return $this->sendRequst($method, $params);
    }

}
