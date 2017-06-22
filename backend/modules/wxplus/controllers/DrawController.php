<?php

/**
 * @filename DrawController.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-4-6 16:20:50
 * @version 1.0
 * @copyright (c) 2016-4-6, 潇湘晨报（版权）
 * @access public 权限
 */

namespace backend\modules\wxplus\controllers;

use components\XyXy;
use Yii;
use yii\web\NotFoundHttpException;
use common\models\activity\LotteryPrize;
use common\models\activity\LotteryList;
use common\models\activity\LotteryWinner;
use common\models\activity\search\LotteryListSearch;
use common\models\activity\search\LotteryWinnerSearch;
use components\helper\CommonUtility;
use yii\data\ActiveDataProvider;

class DrawController extends \backend\modules\wxplus\components\Controller
{

    public function actionIndex()
    {
        $searchModel = new LotteryListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    private function __createGuid()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12);
        return $uuid;
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
            $mod->load($post) && $mod->save() && $this->saveRedis($mod, new \common\models\redis\LotteryList());
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
            $this->saveRedis($mod, new \common\models\redis\LotteryList());
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
                $prize['num'] = $post['LotteryPrize']['num'][$key];
                $prize['bonus_amount'] = $post['LotteryPrize']['bonus_amount'][$key];
                $prize['num_show'] = $post['LotteryPrize']['num_show'][$key];
                $prize['probability'] = $post['LotteryPrize']['probability'][$key];
                $prize['bonus_random'] = $post['LotteryPrize']['bonus_random'][$key]?1:0;
                $prize['max_amount'] = $post['LotteryPrize']['max_amount'][$key];
                $prize['min_amount'] = $post['LotteryPrize']['min_amount'][$key];
                $prize_mod->load($prize, '') && $prize_mod->save() && $this->saveRedis($prize_mod, new \common\models\redis\LotteryPrize());
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

        //是否随机红包
        if ($post['LotteryList']['bonus_random'] && $post['LotteryList']['bonus'])
        {
            $mod->load($post) && $mod->save() && $this->saveRedis($mod, new \common\models\redis\LotteryList());
            LotteryPrize::deleteAll(['act_id' => $id]);
            \common\models\redis\LotteryPrize::deleteAll(['act_id' => $id]);
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
            $this->saveRedis($mod, new \common\models\redis\LotteryList());
            $prize_mod = new LotteryPrize();

            //增加奖项
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
                $prize['num'] = $post['LotteryPrize']['num'][$key];
                $prize['num_show'] = $post['LotteryPrize']['num_show'][$key];
                $prize['bonus_amount'] = $post['LotteryPrize']['bonus_amount'][$key]?:0;
                $prize['probability'] = $post['LotteryPrize']['probability'][$key];
                $prize['bonus_random'] = $post['LotteryPrize']['bonus_random'][$key]?1:0;
                $prize['max_amount'] = $post['LotteryPrize']['max_amount'][$key];
                $prize['min_amount'] = $post['LotteryPrize']['min_amount'][$key];
                $prize_mod->load($prize, '') && $prize_mod->save() && $this->saveRedis($prize_mod, new \common\models\redis\LotteryPrize());
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
        $targetMod->save();
        $this->saveRedis($targetMod, new \common\models\redis\LotteryList());

        $act_id = $targetMod->attributes['id'];

        //复制奖品
        $prizeMod = LotteryPrize::findAll(['act_id' => $id]);
        if ($prizeMod)
        {
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
                $targetPriMod->save();
                $this->saveRedis($targetPriMod, new \common\models\redis\LotteryPrize());
            }
        }
        $this->success('操作成功');
    }

    /**
     * @Desc: 中奖记录
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionWinner($id)
    {
        return $this->render('winner');
    }

    public function actionWinnerList()
    {
        $id = Yii::$app->request->post('id');
        $searchModel = new \common\models\redis\LotteryWinner();
        $data = $searchModel::find()->where(['act_id' => $id])->asArray()->all();
        $this->success('成功', $data);
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
        \components\XyXy::export_csv($filename, $str); //导出
    }
}
