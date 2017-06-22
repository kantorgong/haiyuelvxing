<?php

namespace backend\modules\xxcb;

/**
 * xxcb module definition class
 */
class Module extends \backend\modules\admin\ModuleAdmin
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\xxcb\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
