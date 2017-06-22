<?php
/**
 * 面包屑小物件
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/10/10 10:39
 * @since    1.0
 */

namespace components\widgets;

use Yii;
use yii\helpers\Html;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{

    public $separator = '';
    public function run()
    {
        if (empty($this->links))
        {
            return;
        }
        $links = [];
        if ($this->homeLink === null)
        {
            $links[] = $this->renderItem(['label' => Yii::t('yii', 'Home'), 'url' => Yii::$app->homeUrl], $this->itemTemplate);
        }
        elseif ($this->homeLink !== false)
        {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }
        foreach ($this->links as $link)
        {
            if (!is_array($link))
            {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode($this->separator, $links), $this->options);
    }
}
