<?php

namespace backend\modules\xxcb\controllers;

use \backend\modules\admin\components\Controller;
use common\models\xxcb\FriendShip;
use common\models\xxcb\search\LoveUserSearch;
use common\models\xxcb\search\LoveTaskRecordSearch;
use common\models\xxcb\LoveUser;
use Yii;
/**
 * Default controller for the `xxcb` module
 */
class LoveController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LoveUserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        $userList = LoveUser::find()
                ->where('nickname != "" AND (start_time = 0 or start_time > insert_time)')
                ->select(['uid', 'nickname'])
                ->asArray()
                ->all();

        $rtUser = [];
        if ($userList)
        {
            foreach ($userList as $user)
            {
                $rtUser[$user['uid']] = $user['nickname'];
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rtUser' => $rtUser
        ]);
    }

    /**
     * @Desc: 配对操作
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionMate()
    {
        $uid = Yii::$app->request->get('uid');
        $mid = Yii::$app->request->get('mid');
        $mark = Yii::$app->request->get('mark');
        if (!$uid || !$mid)
        {
            $this->error('配对用户不能为空！');
        }
        LoveUser::updateAll(['mate_uid' => 0], ['mate_uid' => $mid]);
        LoveUser::updateAll(['mate_uid' => $mid], ['uid' => $uid]);
        LoveUser::updateAll(['mate_uid' => $uid], ['uid' => $mid]);

        //用于聊天的talk_id
        $mod = FriendShip::find()->where(['uid' => $uid, 'fid' => $mid])->one();
        if (!$mod)
        {
            $mod = FriendShip::find()->where(['uid' => $mid, 'fid' => $uid])->one();
            if (!$mod)
            {
                $mod = new FriendShip();
                $data = [
                    'uid' => $uid,
                    'fid' => $mid,
                    'talk_id' => \components\helper\CommonUtility::getTalkId($uid, $mid),
                    'status' => 1
                ];
                $mod->load($data, '') && $mod->save();
            }
        }
        $mark && LoveUser::updateAll(['mark' => $mark], ['uid' => $uid]);
        $this->success('配对成功');
    }

    /**
     * @Desc: 任务记录
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionRecord()
    {
        $searchModel = new LoveTaskRecordSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('record', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @Desc: 设置活动开启时间
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionOpen()
    {
        $start_time = Yii::$app->request->get('start_time');
        if (!$start_time) $this->error('开启时间不能为空！');
        $timestamp = strtotime($start_time);
        Yii::$app->memcached->set('love_user:start_time', $timestamp);
        Yii::$app->memcached->set('love_user:day', Yii::$app->request->get('day'));
        Yii::$app->db
                ->createCommand('UPDATE love_user SET start_time = '.$timestamp.' WHERE active_time = 0 AND (start_time = 0 or start_time > insert_time)')
                ->execute();
        $this->success('成功！');
    }
}
