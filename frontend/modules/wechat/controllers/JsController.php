<?php
/**
 * JsController
 * 作者: limj
 * 版本: 17-2-28
 */

namespace frontend\modules\wechat\controllers;
use Yii;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;
class JsController extends Controller
{

    public function actionIndex()
    {
        header("Access-Control-Allow-Origin: *");
        $js = new Application(Yii::$app->params['wechat']['yezilvxing']);
        $jsApi = $js->js;
        if(\Yii::$app->request->get('url'))
        {
            $url = \Yii::$app->request->get('url');
        }
        else
        {
            $url = \Yii::$app->request->referrer;
        }
        $jsInfo = $jsApi->setUrl($url)->config([
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ],true, false, false);
        $return = [];
        $return['appid'] = $jsInfo['appId'];
        $return['timestamp'] = $jsInfo['timestamp'];
        $return['noncestr'] = $jsInfo['nonceStr'];
        $return['signature'] = $jsInfo['signature'];

        $jsonp = \Yii::$app->request->get('callback');
        if($jsonp)
        {
            return $jsonp.'(' . \GuzzleHttp\json_encode($return) . ')';
        }
        else
        {
            return \GuzzleHttp\json_encode($return);
        }
        \Yii::$app->end();
    }
} 