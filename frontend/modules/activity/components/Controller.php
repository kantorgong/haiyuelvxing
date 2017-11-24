<?php
namespace frontend\modules\activity\components;

use frontend\base\BaseFrontController;

class Controller extends BaseFrontController
{
    public $layout = 'main';

    /**
     * 是否来自微信
     */
    protected function _isWechat()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ? true : false;
    }

    /**
     * @Desc: 直接显示的错误信息
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $msg
     */
    protected function _errorShow($msg)
    {
        header("content-type:text/html;charset=utf8");
        echo '<p style="margin-top:120px;font-size:20px;font-weight:bold;">' . $msg .'</p>';
        exit();
    }

    /**
     * @Desc: 必须在微信内
     * @User: zhujw <zhjw@xxcb.cn>
     */
    protected function _needInWechat()
    {
        if(!$this->_isWechat()) //$this->_errorShow('非微信浏览器禁止访问');
        {
            $this->_failReturn('请在微信浏览器内访问该链接！');
        }
    }

    /**
     * @Desc: 去有味进行微信授权
     * @User: zhujw <zhjw@xxcb.cn>
     */
    protected function _wechatOauth($local_url)
    {
        $redirect_uri = 'http://plus.haiyuelvxing.' . \components\XyXy::getEnv() . '/wechatOauth/getWxPublicAutor.html?scope_type=snsapi_userinfo&app_id=4&local_url=' . urlencode($local_url);
        \Yii::$app->response->redirect($redirect_uri)->send();
    }

    protected function _successReturn($ret)
    {
        $jsonp = \Yii::$app->request->get('callback');
        \Yii::$app->response->format = $jsonp ? \yii\web\Response::FORMAT_JSONP : \yii\web\Response::FORMAT_JSON;
        $data['data'] = [
                'status' => 0,
                'message' => '',
                'data' => $ret
        ];
        $jsonp && $data['callback'] = $jsonp;
        \Yii::$app->response->data = $data;
        \Yii::$app->response->send();
        exit;
    }

    protected function _failReturn($message, $ret = null)
    {
        $jsonp = \Yii::$app->request->get('callback');
        \Yii::$app->response->format = $jsonp ? \yii\web\Response::FORMAT_JSONP : \yii\web\Response::FORMAT_JSON;
        $data['data'] = [
                'status' => 1,
                'message' => $message,
                'data' => $ret
        ];
        $jsonp && $data['callback'] = $jsonp;
        \Yii::$app->response->data = $data;
        \Yii::$app->response->send();
        exit;
    }

    protected function _jsonReturn($data)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }
}