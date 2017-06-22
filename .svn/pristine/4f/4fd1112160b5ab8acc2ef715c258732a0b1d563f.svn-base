<?php
/**
 * UserController
 * 作者: limj
 * 版本: 17-3-31
 */

namespace console\controllers;
use yii;
use yii\console\Controller;
use common\models\activity\ScratchUserInfo;
class UserController extends Controller
{
    // 设置redis 键的前缀
    public $preKey = 'QWERTSF';

    /**
     * 描述：每天凌晨01:00 删除前一天没有刮卡的缓存
     */
    public function actionIndex()
    {
        set_time_limit(0);
        $userInfo = \Yii::$app->redis->hgetall($this->__getKey('user_basic_info'));
        foreach($userInfo as $key=>$value)
        {
            $uInfo = json_decode($value, true);
            $model = new ScratchUserInfo();
            $model->open_id = $uInfo['id'];
            $model->name = $uInfo['name'];
            $model->nickname = $uInfo['nickname'];
            $model->avatar = $uInfo['avatar'];
            $model->email = $uInfo['email'];
            $model->sex = $uInfo['original']['sex'];
            $model->language = $uInfo['original']['language'];
            $model->city = $uInfo['original']['city'];
            $model->province = $uInfo['original']['province'];
            $model->country = $uInfo['original']['country'];
            $model->unionid = $uInfo['original']['unionid'];
            if(!$model->save());
            {
                \components\XyXy::log(array_merge($model->getErrors(), array('info'=>$value,'time'=>date('Y-m-d H:i:s'))), 'user_mysql_error');
                $this->stdout("{$uInfo['id']}\n");
            }
        }
    }

    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }
} 