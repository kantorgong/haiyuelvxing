<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;
use common\models\fenglndxdb\UserPoints;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class CallbackController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @Desc: 微信事件通知接口
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionIndex()
    {
        $app = new Application(Yii::$app->params['wechat']['yezilvxing']);
        $server = $app->server;
        $server->setMessageHandler(function($message){
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            if ($message->MsgType == 'event') {
                # code...
                switch ($message->Event) {
                    case 'subscribe':
//                        UserPoints::changePoint(1, '用户关注添加积分', $message->FromUserName);
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
}
