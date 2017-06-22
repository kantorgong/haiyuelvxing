<?php
/**
 * 基础控制器类
 */

namespace backend\modules\cms\components;

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
}