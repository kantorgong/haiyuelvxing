<?php
/**
 * 名称
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/16 17:17
 * @since    1.0
 */

namespace components\web;

use yii;

class BaseController extends \yii\web\Controller
{
    public $_error_log_key = 0;

    /**
     * @Desc: 日志点记录日志功能，请先设置日志点，可从后台开启日志点，在对应页面获取日志点状态，然后调用该方法即可
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $message
     */
    protected function logInfo($message)
    {
        $message && $this->_error_log_key && Yii::error($message);
    }

    /**
     * +----------------------------------------------------------
     * 操作错误跳转的快捷方法
     * +----------------------------------------------------------
     * @access protected
     * +----------------------------------------------------------
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param Boolean $ajax 是否为Ajax方式
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    protected function error($message, $data = null)
    {
        $this->ajaxReturn($data, $message, 1);
    }

    /**
     * +----------------------------------------------------------
     * 操作成功跳转的快捷方法
     * +----------------------------------------------------------
     * @access protected
     * +----------------------------------------------------------
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param Boolean $ajax 是否为Ajax方式
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    protected function success($message, $data = null)
    {
        $this->ajaxReturn($data, $message, 0);
    }

    /**
     * +----------------------------------------------------------
     * Ajax方式返回数据到客户端
     * +----------------------------------------------------------
     * @access protected
     * +----------------------------------------------------------
     * @param mixed $data 要返回的数据
     * @param String $info 提示信息
     * @param boolean $status 返回状态
     * @param String $status ajax返回类型 JSON XML
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    protected function ajaxReturn($data, $message = '', $status = 0, $type = 'JSON')
    {
        $result = array ();
        $result['status'] = $status;
        $result['message'] = $message;
        $result['data'] = $data;
        //扩展ajax返回数据, 在Action中定义function ajaxAssign(&$result){} 方法 扩展ajax返回数据。
        if (method_exists($this, 'ajaxAssign'))
        {
            $this->ajaxAssign($result);
        }

        if (strtoupper($type) == 'JSON')
        {
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:text/html; charset=utf-8');
            exit(json_encode($result));
        }
        elseif (strtoupper($type) == 'XML')
        {
            // 返回xml格式数据
            header('Content-Type:text/xml; charset=utf-8');
            exit(xml_encode($result));
        }
        elseif (strtoupper($type) == 'EVAL')
        {
            // 返回可执行的js脚本
            header('Content-Type:text/html; charset=utf-8');
            exit($data);
        }
        else
        {
            // TODO 增加其它格式
        }
    }


    /**
     * json渲染. PS:调用此方法之前若有输出将会出错
     *
     * @param mixed     $data
     * @param int       $code 0成功 非0错误
     * @param string    $msg  错误信息
     * @param int       $option json_encode options
     */
    public static function renderJson($data, $code = 0, $msg = '', $option = 0) {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $ret = [
            'code' => (int)$code,
            'msg'  => $msg,
            'data' => $data,
        ];

        Yii::$app->response->data = $ret;
        Yii::$app->end();
    }

    /**
     * 获取参数（post/get）的值, 优先级：post > get > default
     *
     * @param string $name 参数名字
     * @param mixed  $default 默认值
     * @return mixed
     */
    public static function getParam($name, $default = null) {
        $post = Yii::$app->request->post($name);
        $get  = Yii::$app->request->get($name);
        return isset($_POST[$name]) ? $post : (isset($_GET[$name]) ? $get : $default);
    }

}