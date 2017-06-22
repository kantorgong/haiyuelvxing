<?php
/**
 * 微信插件基础控制器类
 */

namespace backend\modules\wxplus\components;

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
     * @Desc: 将mysql的数据保存到redis中
     * @User: zhujw <zhjw@xxcb.cn>
     * @param $srcMod
     * @param $targetMod
     */
    public function saveRedis($srcMod, $targetMod)
    {
        $newMod = $targetMod->findOne($srcMod->attributes['id']);
        $targetMod = $newMod?:$targetMod;
        foreach ($srcMod->attributes as $key => $val)
        {
            $targetMod->$key = $val;
        }
        $targetMod->save();
    }
}