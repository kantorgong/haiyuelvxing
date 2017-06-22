<?php
/**
 * @desc 优惠券
 * @date 217-5-16
 * @author gongjt
 */
namespace frontend\modules\activity\controllers;

use components\helper\CommonUtility;
use components\XyXy;
use Yii;
use common\models\wxservice\Coupon;
use common\models\wxservice\CouponLog;
use common\models\wxservice\Users;
use common\models\activity\LotteryList;
use common\models\wxservice\LotteryWinner;

class CouponController extends \frontend\modules\activity\components\Controller
{
    public $enableCsrfValidation = false;

    public function init()
    {
        header('Access-Control-Allow-Origin: http://localhost:8080');
        parent::init();
    }


    public function actionIndex()
    {
        //判断是否在微信内
        if (!$this->_isWechat())
        {
            $this->error(-1, '请在微信内访问本链接');
        }



        //获取优惠券
        $app = Coupon::find('hygl_coupon.*,hygl_coupon_log.status hygl_coupon_log_status')->joinWith('couponLog')->where(['hygl_coupon.status' => 1])->orderBy('hygl_coupon.insert_time desc')->asArray()->limit(20)->all();

        if (!$app)
        {
            $this->error('-1', '优惠券不存在');
        }



        //微信授权
        $this->oauthCheck([
            'app_alias_name' => $app['mp_type'] ?: 'xxcb',
            'ajax' => true,
            'db' => true,
            'silence' => false
        ]);


        $userInfo = Yii::$app->wechat->user;

        $status = 0;

//        判断用户是否已获取过本优惠券
//        $info = CouponLog::find()->where(['open_id' => $userInfo->id, 'coupon_id' =>intval($app['coupon_id'], 0) ])->count();
//        if ($info)
//        {
//            $status = 1;
//        }

        $this->success([
            'couponlist' => $app
        ]);
    }

    //用户获取优惠券
    public function actionReceiveCoupon()
    {
        //判断是否有传参
        $coupon_guid = Yii::$app->request->post('data');

        $coupon_guid = $coupon_guid['coupon_guid'];

        if (!$coupon_guid)
        {
            $this->error(-1, '优惠券不存在3');
        }

        //获取优惠券
        $app = Coupon::find()->where(['coupon_guid' => $coupon_guid])->asArray()->one();
        if (!$app)
        {
            $this->error('-1', '优惠券不存在');
        }


        //微信授权
        $this->oauthCheck([
            'app_alias_name' => $app['mp_type'] ?: 'xxcb',
            'ajax' => true,
            'db' => true,
            'silence' => false
        ]);


        $userInfo = Yii::$app->wechat->user;

        //判断用户是否已报名
        $info = CouponLog::find()->where(['open_id' => $userInfo->id, 'coupon_id' => $app['coupon_id']])->count();

        if ($info)
        {
            $this->error(-1, '你已经获取过了');
        }

        $myuser = Users::find()->where(['open_id' => $userInfo->id])->one();
//        写入数据库
        $post = [
            'coupon_id' => intval($app['coupon_id'], 0),
            'ip' => Yii::$app->request->userIP,
            'insert_time' => time(),
            'userid' => $myuser->uid,
            'open_id' => $userInfo->id,
            'nickname' => $userInfo->nickname
        ];


        //静态测试
//        $post = [
//            'coupon_id' => intval($app['coupon_id'], 0),
//            'ip' => Yii::$app->request->userIP,
//            'insert_time' => time(),
//            'userid' => 17,
//            'open_id' => 'okFt4t3lWd5WOzjdKqkKaLm2wkxE',
//            'nickname' => '疆韬'
//        ];



        $model = new CouponLog();
        $model->load($post, '') && $model->save();

        $this->success();
    }

    //分享到朋友圈、群、朋友
    public function actionShare()
    {
        try
        {
            $app = Coupon::find()->asArray()->one();
            $this->oauthCheck([
                'app_alias_name' => $app['mp_type'] ?: 'xxcb',
                'ajax' => true,
                'db' => true,
                'silence' => false
            ]);
            $userInfo = Yii::$app->wechat->user;
            $userid = $userInfo->id;

            $maxid = CouponLog::find('id')->andWhere(["open_id" => $userid])->orderBy('id desc')->one();

            $log = CouponLog::updateAll(["share_time" => time()], ["id" => $maxid]);
            $lottery = LotteryList::find('group_id')->andWhere(['<=', 'status', 1])->andWhere(['<', 'start_time' , time()])->andWhere(['>' , 'end_time' , time()])->orderBy('id desc')->one();
            $this->success([
                'group_id' => $lottery->group_id
            ]);
        }
        catch (\yii\base\Exception $e)
        {
            $this->error($e->getMessage());
        }

    }

    //用户中心
    public function actionMy()
    {
        $app = Coupon::find()->asArray()->one();
        //微信授权
        $this->oauthCheck([
            'app_alias_name' => $app['mp_type'] ?: 'xxcb',
            'ajax' => true,
            'db' => true,
            'silence' => false
        ]);


        $userInfo = Yii::$app->wechat->user;
        $nickname = $userInfo->nickname;
        $headimgurl = $userInfo->avatar;


        $status = 0;
        $this->success([
            'status' => $status,
            'nickname' => $nickname,
            'headimgurl' => $headimgurl
        ]);
    }


    //用户中心-我的优惠券
    public function actionMyCoupon()
    {
        $userInfo = Yii::$app->wechat->user;
        $myuser = Users::find()->where(['open_id' => $userInfo->id])->one();
        $userid = $myuser->uid;
        //获取优惠券
        $app = CouponLog::find()->select('hygl_coupon_log.*,hygl_coupon.title,hygl_coupon.price,hygl_coupon.depict')->joinWith(['coupon'])->andWhere(['hygl_coupon_log.userid' => $userid])->orderBy('hygl_coupon_log.id desc')->asArray()->all();
        if (!$app)
        {
            $this->error('-1', '你没有优惠券');
        }
        $status = 0;
        $this->success([
            'status' => $status,
            'mycoupon' => $app
        ]);
    }
    //用户中心-我的抽奖
    public function actionMyPrize()
    {
        $app = Coupon::find()->asArray()->one();
        //微信授权
        $this->oauthCheck([
            'app_alias_name' => $app['mp_type'] ?: 'xxcb',
            'ajax' => true,
            'db' => true,
            'silence' => false
        ]);


        $userInfo = Yii::$app->wechat->user;
        $userid = $userInfo->id;
        //获取抽奖
        $app = LotteryWinner::find()->select('lottery_winner.*, lottery_prize.*,  lottery_list.act_name')->joinWith(['lottery'])->joinWith(['prizeitem'])->andWhere(['lottery_winner.open_id' => $userid])->orderBy('lottery_winner.id desc')->asArray()->all();
        if (!$app)
        {
            $this->error('-1', '你没有获奖记录');
        }
        $status = 0;
        $this->success([
            'status' => $status,
            'myprize' => $app
        ]);
    }
}
