<?php
/**
 * 视图基类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/28 11:10
 * @since    1.0
 */

namespace components\web;


use Yii;
use yii\web\View;
use components\XyXy;
use components\widgets\InhritLayout;
use components\helper\CommonUtility;
use yii\base\InvalidParamException;

/**
 * Site controller
 */
class BaseView extends View
{

    public $channels;

    public $rootChannels;

    public function init()
    {
        parent::init();
    }

    public function getChannel($chnid)
    {
        if(! isset($this->channels[$chnid]))
        {
            XyXy::info('channel id:' . $chnid . ' does not exist');
            throw new InvalidParamException('channel id:' . $chnid . ' does not exist');
        }
        return $this->channels[$chnid];
    }

    public function getChildChannels($chnid)
    {
        $ret = [];

        $currentChannel = $this->getChannel($chnid);
        $childIds = explode(',', $currentChannel['child_ids']);
        foreach($childIds as $id)
        {
            if(empty($id))
            {
                continue;
            }
            $ret[$id] = $this->getChannel($id);
        }
        return $ret;
    }

    public function setMetaTag($name, $content)
    {
        $this->registerMetaTag(['name' => $name, 'content' => $content]);
    }

    public function beginInhritLayout($viewFile, $params = [], $blocks = [])
    {
        return InhritLayout::begin(['viewFile' => $viewFile, 'params' => $params, 'blocks' => $blocks, 'view' => $this]);
    }

    public function endInhritLayout()
    {
        InhritLayout::end();
    }

    public function addBreadcrumb()
    {
        $argsCount = func_num_args();
        $args = func_get_args();

        if($argsCount == 1)
        {
            $this->params['breadcrumbs'][] = $args[0];
        }
        else if($argsCount == 2)
        {
            $this->params['breadcrumbs'][] = ['label' => $args[0], 'url' => $args[1]];
        }
    }
}
