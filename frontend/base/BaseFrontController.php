<?php

namespace frontend\base;

use Yii;
use components\web\BaseController;
use common\models\wxservice\Users;

class BaseFrontController extends BaseController
{
    /**
     * @Desc: 微信认证
     * @User: zhujw <zhjw@xxcb.cn>
     * @param bool|true
     * [
        'app_alias_name' => 'uv',   //操作公众号别名，默认为uv
        'silence' => false,         //是否静默授权，默认非静默
        'db' => false               //是否操作数据库，默认不操作，静默授权同样不会操作数据库
       ]
     * @return mixed
     */
    protected function oauthCheck($option = [])
    {
        //来源微信公众号
        $app = !isset($option['app_alias_name']) ? 'uv' : $option['app_alias_name'];
        Yii::$app->session->set('wxs_wechatApp', $app);

        //是否静默授权
        if (isset($option['silence']) && $option['silence'])
        {
            Yii::$app->session->set('wxs_wechatSilence_' . $app, true);
        }

        $wechat = Yii::$app->wechat;
        if($wechat->isWechat && !$wechat->isAuthorized())
        {
            if ($option['ajax']) $this->error(-2, '请先授权');
            else return $wechat->authorizeRequired()->send();
        }

        //静默授权不需要操作数据库
        if ((!isset($option['silence']) || !$option['silence']) && isset($option['db']) && $option['db'] && $wechat->isAuthorized())
        {
            $userInfo = $wechat->user;

            //保存用户
            if (!Users::find()->where(['open_id' => $userInfo->id])->count() && $userInfo->nickname)
            {
                $mod = new Users();
                $mod->open_id = $userInfo->id;
                $mod->nickname = $userInfo->nickname;
                $mod->sex = $userInfo->original['sex'];
                $mod->province = $userInfo->original['province'];
                $mod->city = $userInfo->original['city'];
                $mod->country = $userInfo->original['country'];
                $mod->headimgurl = $userInfo->original['headimgurl'];
                $mod->insert_time = time();
                $userInfo->original['unionid'] && $mod->union_id = $userInfo->original['unionid'];
                $mod->save();
            }
        }
    }

    /**
     * ajax返回失败
     *
     * @param int       $code 状态妈妈
     * @param mixed     $data 返回给前端的数据
     * @param boolean   $jsonp  是否jsonp请求
     */
    protected function error($code, $data = null, $jsonp = false)
    {
        $this->renderJson($code, $data, $jsonp);
    }

    /**
     * ajax返回成功
     *
     * @param mixed     $data 返回给前端的数据
     * @param boolean   $jsonp  是否jsonp请求
     */
    protected function success($data = null, $jsonp = false)
    {
        $this->renderJson(0, $data, $jsonp);
    }

    /**
     * json渲染. PS:调用此方法之前若有输出将会出错
     *
     * @param int       $code 0成功 非0错误
     * @param mixed     $data 返回给前端的数据
     * @param boolean   $jsonp  是否jsonp请求
     */
    public static function renderJson($code = 0, $data = null, $jsonp = false)
    {
        Yii::$app->response->format = $jsonp ? \yii\web\Response::FORMAT_JSONP : \yii\web\Response::FORMAT_JSON;
        $ret = [
                'code' => (int)$code,
                'data' => $data,
        ];

        Yii::$app->response->data = $ret;
        Yii::$app->end();
    }
}