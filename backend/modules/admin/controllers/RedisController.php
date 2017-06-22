<?php
/**
 * RedisController
 * 作者: limj
 * 版本: 17-4-20
 */

namespace backend\modules\admin\controllers;
use Yii;

class RedisController extends \backend\modules\admin\components\Controller
{

    public $keyType = ['hash'=> '哈希','list'=>'列表','zset'=>'有序集合','set'=>'集合'];
    public $limit = 50;
    /**
     * Lists all sysvariable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $list = [];
        if($key = trim(urldecode(Yii::$app->request->get('key'))))
        {
            $key = '*' . $key . '*';
            $list = Yii::$app->redis->keys($key);
        }
        else
        {
            $list = Yii::$app->redis->keys('*');
        }
        $list = $this->limitPage($list);
        return $this->render('index',['list'=>$list,'keyType'=>$this->keyType]);
    }

    /**
     * 描述：删除redis中键
     */
    public function actionAjaxDel()
    {
        $key = Yii::$app->request->get('key');
        if(empty($key)) $this->error('操作失败');
        Yii::$app->redis->del($key);
        $this->success('操作成功');
    }

    /**
     * 描述：删除键中的值
     */
    public function actionAjaxIddel()
    {
        $key = Yii::$app->request->get('key');
        $id = Yii::$app->request->get('id');
        $keyType = Yii::$app->request->get('type');
        if(!isset($key) && !isset($id)) $this->error('操作失败');
        if($keyType == 'hash')
        {
            Yii::$app->redis->hdel($key, $id);
        }
        elseif($keyType == 'set')
        {
            Yii::$app->redis->srem($key, $id);
        }
        elseif($keyType == 'zset')
        {
            Yii::$app->redis->zrem($key, $id);
        }
        $this->success('操作成功');
    }

    public function actionList()
    {
        $list = [];
        if(Yii::$app->request->isPost && Yii::$app->request->post('id'))
        {
            $key = trim(urldecode(Yii::$app->request->post('key')));
            $id = trim(urldecode(Yii::$app->request->post('id')));
            $keyType = Yii::$app->request->post('keyType');
            $list = [];
            if($keyType == 'hash')
            {
                $getVal = Yii::$app->redis->hget($key, $id);
                if(isset($getVal))
                {
                    $list[0] = $id;
                    $list[1] = $getVal;
                }
            }
            elseif($keyType == 'list')
            {
                $getVal = Yii::$app->redis->lindex($key, $id);
                if(isset($getVal))
                {
                    $list[$id] = $getVal;
                }
            }
            elseif($keyType == 'zset')
            {
                $getVal = Yii::$app->redis->zrank($key, $id);
                if(isset($getVal))
                {
                    $list[] = $id;
                }
            }
            elseif($keyType == 'set')
            {
                $getVal = Yii::$app->redis->sismember($key, $id);
                if($getVal == 1)
                {
                    $list[] = $id;
                }
            }
            \Yii::$app->session['redisCount'] = count($list);
        }
        else
        {
            $key = Yii::$app->request->get('key') ? trim(Yii::$app->request->get('key')) : trim(Yii::$app->request->post('key'));

            $keyType = Yii::$app->redis->type($key);
            if($keyType == 'hash')
            {
                $list = Yii::$app->redis->hgetall($key);
            }
            elseif($keyType == 'list')
            {
                $lenth = Yii::$app->redis->llen($key);
                $list = Yii::$app->redis->lrange($key,0,$lenth);
            }
            elseif($keyType == 'zset')
            {
                $lenth = Yii::$app->redis->zcard($key);
                $list = Yii::$app->redis->zrevrange($key,0,$lenth);
            }
            elseif($keyType == 'set')
            {
                $list = Yii::$app->redis->smembers($key);
            }

            $list = $this->limitPage($list);
        }
        return $this->render('list',['list'=>$list,'keyType'=>$keyType]);
    }

    /**
     * 描述：修改字符串类型 值
     */
    public function actionUpdate()
    {
        if($key = \Yii::$app->request->post('key'))
        {
            Yii::$app->redis->set($key, \Yii::$app->request->post('value'));
            return $this->redirect(['index', 'key'=>$key]);
        }
        return $this->render('update');
    }

    /**
     * 描述：修改非字符串类型的值
     */
    public function actionEdit()
    {
        if($key = \Yii::$app->request->post('key'))
        {
            $keyType = Yii::$app->redis->type($key);
            if($keyType == 'hash')
            {
                $id = \Yii::$app->request->post('id');
                Yii::$app->redis->hset($key, $id, \Yii::$app->request->post('value'));
            }
            elseif($keyType == 'list')
            {
                $id = \Yii::$app->request->post('id');
                Yii::$app->redis->lset($key, $id, \Yii::$app->request->post('value'));
            }
            return $this->redirect(['list', 'key'=>$key]);
        }
        return $this->render('edit',['keyType'=>$keyType]);
    }

    /**
     * 描述：分页
     */
    private function limitPage($list)
    {
        $page = Yii::$app->request->get('page', 0);
        if($page === 'pre')
        {
            // 上一页
            $page = \Yii::$app->session['redisPage'] = \Yii::$app->session['redisPage']-1 < 0 ? 0 : \Yii::$app->session['redisPage']-1;
        }
        elseif($page === 'next')
        {
            // 下一页
            $page = \Yii::$app->session['redisPage'] = \Yii::$app->session['redisPage'] + 1;
        }
        else
        {
            $page = \Yii::$app->session['redisPage'] = 0;
        }
        \Yii::$app->session['redisCount'] = count($list);
        $start = $page * $this->limit;
        $list = array_slice($list, $start, $this->limit, true);
        return $list;
    }
} 