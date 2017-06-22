<?php
/**
 * @desc 活动报名
 * @date 217-5-8
 * @author zhujw
 */
namespace frontend\modules\activity\controllers;

use components\helper\CommonUtility;
use Yii;
use common\models\Apply;
use common\models\Applyinfo;

class ApplyController extends \frontend\modules\activity\components\Controller
{
    public $enableCsrfValidation = false;

    public function init()
    {
        header('Access-Control-Allow-Origin: http://localhost:8080');
        parent::init();
    }

    /**
     * @Desc: 报名数据初始化
     * @User: zhujw <zhjw@xxcb.cn>
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        //判断是否在微信内
        if (!$this->_isWechat())
        {
            $this->error(-1, '请在微信内访问本链接');
        }

        //判断是否有传参
        $guid = Yii::$app->request->get('guid');
        if (!$guid)
        {
            $this->error(-1, '报名活动不存在');
        }

        //获取报名活动详情
        $app = Apply::find()->where(['guid' => $guid])->asArray()->one();
        if (!$app)
        {
            $this->error('-1', '报名活动不存在');
        }
        $now = time();
        if ($now < $app['start_time'])
        {
            $this->error('-1', '报名活动尚未开启');
        }
        if ($now > $app['end_time'])
        {
            $this->error('-1', '报名活动已结束');
        }

        //微信授权
        $this->oauthCheck([
                'app_alias_name' => $app['mp_type'] ?: 'xxcb',
                'ajax' => true
        ]);

        $userInfo = Yii::$app->wechat->user;

        $status = 0;

        //判断用户是否已报名
        $info = Applyinfo::find()->where(['openid' => $userInfo->id])->count();
        if ($info)
        {
            $status = 1;
        }

        $this->success([
            'status' => $status,
            'form' => \GuzzleHttp\json_decode(stripslashes($app['forms']))
        ]);
    }

    /**
     * @Desc: 保存数据
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionSaveInfo()
    {
        $data = Yii::$app->request->post('data');

        if (!$guid = $data['guid'])
        {
            $this->error(-1, '活动不存在');
        }

        unset($data['guid']);

        if (!$data)
        {
            $this->error(-1, '你未提交任何数据');
        }

        //获取报名活动详情
        $app = Apply::find()->where(['guid' => $guid])->asArray()->one();
        if (!$app)
        {
            $this->error('-1', '报名活动不存在');
        }
        $now = time();
        if ($now < $app['start_time'])
        {
            $this->error('-1', '报名活动尚未开启');
        }
        if ($now > $app['end_time'])
        {
            $this->error('-1', '报名活动已结束');
        }

        //微信授权
        $this->oauthCheck([
                'app_alias_name' => $app['mp_type'] ?: 'xxcb',
                'ajax' => true
        ]);

        $userInfo = Yii::$app->wechat->user;

        //判断用户是否已报名
        $info = Applyinfo::find()->where(['openid' => $userInfo->id])->count();
        if ($info)
        {
            $this->error(-1, '你已经报过名啦');
        }

        //写入数据库
        $post = [
            'apply_id' => $app['id'],
            'ip' => Yii::$app->request->userIP,
            'info_values' => \GuzzleHttp\json_encode($data),
            'insert_time' => time(),
            'openid' => $userInfo->id,
            'nickname' => $userInfo->nickname
        ];

        $model = new Applyinfo();
        $model->load($post, '') && $model->save();
        $this->success();
    }
}
