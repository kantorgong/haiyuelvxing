<?php

namespace backend\modules\wxservice\controllers;

use components\XyXy;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\wxservice\LotteryPrize;
use common\models\wxservice\LotteryList;
use common\models\wxservice\LotteryWinner;
use common\models\wxservice\search\LotteryListSearch;
use common\models\wxservice\search\LotteryWinnerSearch;
use components\helper\CommonUtility;
use dosamigos\qrcode\QrCode;

class DrawController extends \backend\modules\wxservice\components\Controller
{
    public function actionIndex()
    {
//        $a = Yii::$app->redis->hvals('lottery_group:82826EE0-E05E-BBBD-4B8D-A3AC173B9B9B');
//        \components\XyXy::dump($a);die;
        $searchModel = new LotteryListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * @Desc: 添加奖品
     * @User: zhujw <zhjw@xxcb.cn>
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $mod = new LotteryList();
        if(!Yii::$app->request->isPost)
        {
            $prize_mod = new LotteryPrize();
            return $this->render('create', ['model' => $mod, 'prize_mod' => $prize_mod]);
        }

        $post = Yii::$app->request->post();
        $post['LotteryList']['guid'] = CommonUtility::createGuid();

        //是否随机红包
        if ($post['LotteryList']['bonus_random'] && $post['LotteryList']['bonus'])
        {
            if ($mod->load($post) && $mod->save())
            {
                $arr = $this->unsetRedisField(ArrayHelper::toArray($mod));
                Yii::$app->redis->hset(
                        'lottery_group:' . $mod->attributes['group_id'],
                        'lottery_list:' . $mod->attributes['id'],
                        \GuzzleHttp\json_encode($arr)
                );
            }
            return $this->redirect(['index']);
        }

        //计算总的中奖概率
        $probability = 0;
        foreach ($post['LotteryPrize']['probability'] as $p)
        {
            $probability += $p;
        }
        if ($probability > 10000)
            throw new NotFoundHttpException('中奖概率总和不能大于10000，当前总和【' . $probability . '】');

        //新增活动
        if ($mod->load($post) && $mod->save())
        {
            $arr = $this->unsetRedisField(ArrayHelper::toArray($mod));
            Yii::$app->redis->hset(
                    'lottery_group:' . $mod->attributes['group_id'],
                    'lottery_list:' . $mod->attributes['id'],
                    \GuzzleHttp\json_encode($arr)
            );

            $act_id = $mod->attributes['id'];
            $prize_mod = new LotteryPrize();

            //增加奖项
            foreach ($post['LotteryPrize']['name'] as $key => $value)
            {
                $prize_mod->isNewRecord = true;
                $prize['id'] = 0;
                $prize['act_id'] = $act_id;
                $prize['name'] = $post['LotteryPrize']['name'][$key];
                $prize['content'] = $post['LotteryPrize']['content'][$key];
                $prize['num'] = isset($post['LotteryPrize']['num'][$key]) ? $post['LotteryPrize']['num'][$key] : 0;
                $prize['bonus_amount'] = isset($post['LotteryPrize']['bonus_amount'][$key]) ? $post['LotteryPrize']['bonus_amount'][$key] : 0;
                $prize['num_show'] = isset($post['LotteryPrize']['num_show'][$key]) ? $post['LotteryPrize']['num_show'][$key] : 0;
                $prize['probability'] = $post['LotteryPrize']['probability'][$key];
                $prize['bonus_random'] = isset($post['LotteryPrize']['bonus_random'][$key]) ? $post['LotteryPrize']['bonus_random'][$key] : 0;
                $prize['max_amount'] = isset($post['LotteryPrize']['max_amount'][$key]) ? $post['LotteryPrize']['max_amount'][$key] : 0;
                $prize['min_amount'] = isset($post['LotteryPrize']['min_amount'][$key]) ? $post['LotteryPrize']['min_amount'][$key] : 0;
                if ($prize_mod->load($prize, '') && $prize_mod->save())
                {
                    $arr = $this->unsetRedisField(ArrayHelper::toArray($prize_mod));
                    Yii::$app->redis->hset(
                            'lottery_list:' . $act_id,
                            'lottery_prize:' . $prize_mod->attributes['id'],
                            \GuzzleHttp\json_encode($arr)
                    );
                }
            }
        }
        else
        {
            \components\XyXy::dump($mod);
        }
        return $this->redirect(['index']);
    }

    /**
     * @Desc: 修改活动
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $mod = $this->findModel($id);
        if(!Yii::$app->request->isPost)
        {
            $prize_mod = new LotteryPrize();
            $prizes = LotteryPrize::find()->where(['act_id' => $mod->id])->asArray()->all();
            return $this->render('update', ['model' => $mod, 'prize_mod' => $prize_mod, 'prizes' => $prizes]);
        }

        $post = Yii::$app->request->post();

        //每次活动修改都将重置激活的活动ID
        Yii::$app->redis->del('lottery_active:' . $post['LotteryList']['group_id']);

        //是否随机红包
        if ($post['LotteryList']['bonus_random'] && $post['LotteryList']['bonus'])
        {
            if ($mod->load($post) && $mod->save())
            {
                $arr = $this->unsetRedisField(ArrayHelper::toArray($mod));
                Yii::$app->redis->hset(
                        'lottery_group:' . $mod->attributes['group_id'],
                        'lottery_list:' . $mod->attributes['id'],
                        \GuzzleHttp\json_encode($arr)
                );
            }
            LotteryPrize::deleteAll(['act_id' => $id]);
            Yii::$app->redis->del('lottery_list:' . $id);
            return $this->redirect(['index']);
        }

        //计算总的中奖概率
        $probability = 0;
        foreach ($post['LotteryPrize']['probability'] as $p)
        {
            $probability += $p;
        }
        if ($probability > 10000)
            throw new NotFoundHttpException('中奖概率总和不能大于10000，当前总和【' . $probability . '】');

        if ($mod->load($post) && $mod->save())
        {
            $arr = $this->unsetRedisField(ArrayHelper::toArray($mod));
            Yii::$app->redis->hset(
                    'lottery_group:' . $mod->attributes['group_id'],
                    'lottery_list:' . $mod->attributes['id'],
                    \GuzzleHttp\json_encode($arr)
            );
            $prize_mod = new LotteryPrize();

            //增加奖项
            $idList = [];
            foreach ($post['LotteryPrize']['name'] as $key => $value)
            {
                if (!$post['LotteryPrize']['id'][$key])
                {
                    $prize_mod->isNewRecord = true;
                    $prize['id'] = 0;
                }
                else
                {
                    $prize_mod = $prize_mod::findOne($post['LotteryPrize']['id'][$key]);
                }

                $prize['act_id'] = $id;
                $prize['name'] = $post['LotteryPrize']['name'][$key];
                $prize['content'] = $post['LotteryPrize']['content'][$key];
                $prize['num'] = isset($post['LotteryPrize']['num'][$key]) ? $post['LotteryPrize']['num'][$key] : 0;
                $prize['num_show'] = isset($post['LotteryPrize']['num_show'][$key]) ? $post['LotteryPrize']['num_show'][$key] : 0;
                $prize['bonus_amount'] = isset($post['LotteryPrize']['bonus_amount'][$key]) ? $post['LotteryPrize']['bonus_amount'][$key] : 0;
                $prize['probability'] = $post['LotteryPrize']['probability'][$key];
                $prize['bonus_random'] = isset($post['LotteryPrize']['bonus_random'][$key]) ? $post['LotteryPrize']['bonus_random'][$key] : 0;
                $prize['max_amount'] = isset($post['LotteryPrize']['max_amount'][$key]) ? $post['LotteryPrize']['max_amount'][$key] : 0;
                $prize['min_amount'] = isset($post['LotteryPrize']['min_amount'][$key]) ? $post['LotteryPrize']['min_amount'][$key] : 0;
                if ($prize_mod->load($prize, '') && $prize_mod->save())
                {
                    $idList[] = $prize_mod->attributes['id'];
                    $arr = $this->unsetRedisField(ArrayHelper::toArray($prize_mod));
                    Yii::$app->redis->hset(
                            'lottery_list:' . $id,
                            'lottery_prize:' . $prize_mod->attributes['id'],
                            \GuzzleHttp\json_encode($arr)
                    );
                }
                else
                {
                    \components\XyXy::dump($prize_mod);die;
                }
            }

            //删除选项
            LotteryPrize::deleteAll(['and', ['act_id' => $id], ['not in', 'id', $idList]]);

            //redis删除选项
            $hKeys = Yii::$app->redis->hkeys('lottery_list:' . $id);
            foreach ($hKeys as $k)
            {
                $key = explode(':', $k);
                if (!in_array($key[1], $idList))
                {
                    Yii::$app->redis->hdel('lottery_list:' . $id, 'lottery_prize:' . $key[1]);
                }
            }
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = LotteryList::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @Desc: 复制活动的操作
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $id
     */
    public function actionCopy($id)
    {
        $srcMod = $this->findModel($id);
        $targetMod = new LotteryList();
        foreach ($srcMod->attributes as $key => $val)
        {
            if ($key == 'id') continue;
            if ($key == 'guid')
            {
                $targetMod->guid = CommonUtility::createGuid();
                continue;
            }
            if ($key == 'start_time' || $key == 'end_time')
            {
                $targetMod->$key = date('Y-m-d H:i:s', $val);
                continue;
            }
            $targetMod->$key = $val;
        }
        if ($targetMod->save())
        {
            $arr = $this->unsetRedisField(ArrayHelper::toArray($targetMod));
            Yii::$app->redis->hset(
                    'lottery_group:' . $targetMod->attributes['group_id'],
                    'lottery_list:' . $targetMod->attributes['id'],
                    \GuzzleHttp\json_encode($arr)
            );
        }

        $act_id = $targetMod->attributes['id'];

        //复制奖品
        $prizeMod = LotteryPrize::findAll(['act_id' => $id]);
        if ($prizeMod)
        {
            //redis删除原有选项
            $hKeys = Yii::$app->redis->hkeys('lottery_list:' . $act_id);
            foreach ($hKeys as $k)
            {
                $key = explode(':', $k);
                Yii::$app->redis->hdel('lottery_list:' . $act_id, 'lottery_prize:' . $key[1]);
            }
            foreach ($prizeMod as $pri)
            {
                $targetPriMod = new LotteryPrize();
                foreach ($pri->attributes as $key => $val)
                {
                    if ($key == 'id') continue;
                    if ($key == 'act_id')
                    {
                        $targetPriMod->act_id = $act_id;
                        continue;
                    }
                    $targetPriMod->$key = $val;
                }
                if ($targetPriMod->save())
                {
                    $arr = $this->unsetRedisField(ArrayHelper::toArray($targetPriMod));
                    Yii::$app->redis->hset(
                            'lottery_list:' . $act_id,
                            'lottery_prize:' . $targetPriMod->attributes['id'],
                            \GuzzleHttp\json_encode($arr)
                    );
                }
            }
        }
        $this->success('操作成功');
    }

    public function actionStatistics($id)
    {
        return $this->render('statistics');
    }

    /**
     * @Desc: 中奖记录
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionWinner($id)
    {
        $searchModel = new LotteryWinnerSearch();
        $params = Yii::$app->request->getQueryParams();
        $params['LotteryWinnerSearch']['act_id'] = $id;
        $dataProvider = $searchModel->search($params);
        return $this->render('winner', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * @Desc: 导出获奖数据
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $id
     */
    public function actionExport($id)
    {
        $data = LotteryWinner::find()
                ->where(['act_id' => $id])
                ->select(['name', 'phone', 'prize_id'])
                ->asArray()
                ->all();
        if (!$data)
            throw new NotFoundHttpException('没有可导出的数据');

        $prize = LotteryPrize::find()
                ->where(['act_id' => $id])
                ->select(['id', 'name'])
                ->asArray()
                ->all();

        if (!$prize)
            throw new NotFoundHttpException('没有可导出的数据');

        $map = [];
        foreach ($prize as $p)
        {
            $map[$p['id']] = $p['name'];
        }

        $str = "姓名,手机号,奖项\n";
        $str = iconv('utf-8','gb2312',$str);
        foreach($data as $d)
        {
            $name = iconv('utf-8', 'gb2312', $d['name']); //中文转码
            $prize = iconv('utf-8', 'gb2312', $map[$d['id']]);
            $str .= $name. ',' . $d['phone'] . ',' . $prize . "\n"; //用引文逗号分开
        }

        $filename = date('Ymd').'.csv'; //设置文件名
        \components\helper\CommonUtility::export_csv($filename, $str);
    }

    /**
     * @Desc: 获取领奖二维码
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $guid
     */
    public function actionGetPrize($guid='', $id, $title='')
    {
        $redis = Yii::$app->redis;
        //设置密码
        if (Yii::$app->request->isPost)
        {
            $redis->set('lottery_prize_pwd:' . $id, Yii::$app->request->post('pwd'));
            $this->success('密码设置成功');
        }
        //判断是否已经设置好密码
        $pwd = $redis->get('lottery_prize_pwd:' . $id);
        return $this->render('get-prize', [
            'pwd' => $pwd,
            'guid' => $guid,
            'title' => $title
        ]);
    }

    /**
     * @Desc: 生成领奖二维码
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionQrcode($guid)
    {
        $test = YII_ENV == 'test' ? 'test.' : '';
        return QrCode::png('http://' . $test . 'plus.haiyuelvxing.com/lottery/#/prize/' . $guid, false, 0, 6);
    }
}
