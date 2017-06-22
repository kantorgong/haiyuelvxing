<?php
/**
 * FocusController
 */

namespace frontend\modules\wechat\controllers;
use Yii;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\Image;

class FocusController extends Controller
{
    //应用实例
    private static $_instance;

    public $enableCsrfValidation = false;

    private function _getInstance()
    {
        if(!self::$_instance instanceof Application)
        {
            self::$_instance = new Application(Yii::$app->params['wechat']['xxcb']);
        }
        return self::$_instance;
    }

    public function actionIndex()
    {
        $server = $this->_getInstance()->server;
        $server->setMessageHandler(function($message){
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            $redis = Yii::$app->redis;
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        //判断是否带有参数
                        if (isset($message->EventKey))
                        {
                            //获取对应用户的open_id
                            $ek = explode('_', $message->EventKey);
                            $openId = $redis->get('focus_mapping_' . $ek[1]);

                            //通过open_id来关注的用户+1
                            $num = $redis->incr('focus_from_' . $ek[1]);

                            //给对应用户推送消息
                            $this->_getInstance()->staff
                                    ->message(new Text(['content' => '已经有 ' . $num . ' 位用户通过你的分享关注了我们的公众号！']))
                                    ->to($openId)
                                    ->send();

                        }
                        return $this->_getQrcode($message->FromUserName);
                        break;
                    default:
                        # code...
                        break;
                }
            }
        });
        $response = $server->serve();
        $response->send();
    }

    private function _getQrcode($openId)
    {
        $redis = Yii::$app->redis;
        $code = \Yii::$app->basePath . '/runtime/code.jpg';

        //生成对应ID映射表
        $user_id = $redis->incr('wechat_focus_user_id');
        $redis->set('focus_mapping_' . $user_id, $openId);


        //创建临时二维码
        $qrcode = $this->_getInstance()->qrcode;
        $result = $qrcode->temporary($user_id, 2592000);
        $ticket = $result->ticket;

        //获取图片
        $url = $qrcode->url($ticket);
        $content = file_get_contents($url); // 得到二进制图片内容
        file_put_contents($code, $content); // 写入文件


        //上传到微信临时素材库，并获取media_id
        $temporary = $this->_getInstance()->material_temporary;
        $res = $temporary->uploadImage($code);

        //返回二维码给用户
        return new Image(['media_id' => $res->media_id]);
    }
} 