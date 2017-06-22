<?php
/**
 * 微信插件基础控制器类
 */

namespace backend\modules\wxservice\components;

class Controller extends \components\web\BaseController
{
    protected $_viewPaht;
    public $layout = 'main';

    public function beforeAction($action)
    {
        //记录日志
        //$this->_writerLog();

        return TRUE;
    }

    public function getViewPath()
    {
        if ($this->_viewPaht == null)
        {
            return parent::getViewPath();
        }
        return $this->_viewPaht;
    }

    public function setViewPath($path)
    {
        $this->_viewPaht = $path;
    }

    /**
     * @Desc: 释放不需要存入redis的字段
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $arr
     * @return mixed
     */
    public function unsetRedisField($arr)
    {
        unset($arr['insert_time'], $arr['insert_id'], $arr['modify_id'], $arr['modify_time']);
        return $arr;
    }
}