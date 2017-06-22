<?php
/**
 * 通用服务基础控制器类
 */

namespace backend\modules\service\components;

class Controller extends \components\web\BaseController
{
    protected $_viewPaht;
    public $layout = 'main';

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