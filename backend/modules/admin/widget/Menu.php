<?php
/**
 * Created by PhpStorm.
 * User: gongjt
 * Date: 2015/9/15
 * Time: 12:02
 */

namespace backend\modules\admin\widget;

use yii\helpers\ArrayHelper;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;
use \components\helper\Tree;
use backend\modules\admin\components\User;


class Menu extends \yii\widgets\Menu
{
    public $options = [
        'class' => 'nav-item',
    ];

    public $items = [

    ];

    public $submenuTemplate = '<li class ="nav-item">{items}</li>';

    public function init()
    {
        $this->items = ArrayHelper::merge($this->items, $this->getItems());
    }

    private function getItems()
    {
//        $menus = User::getUser()->getMenu();
        $user = new User();
        $menus = $user->getMenu();

        foreach ($menus as $k => $v)
        {
            if ($v['display'])
            {
                unset($menus[$k]);
                continue;
            }
            $menus[$k] = [
                'id' => $v['id'],
                'label' => $v['name'],
                'url' => ($v['controller'] == '#') ? '' : ['/' . $v['controller'] . '/' . $v['action']],
                'icon' => $v['icon'],
                'parentid' => $v['parentid']
            ];

        }
        $menus = Tree::getInstance()->setData($menus)->getTree(0, 0, false, 'items');
        return $menus;

    }


    protected function renderItems($items)
    {
        //首页
        $hometag = '<li class="sidebar-toggler-wrapper hide">
                        <div class="sidebar-toggler">
                            <span></span>
                        </div>
                    </li>
                    <li class="sidebar-search-wrapper">
                        <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                            <a href="javascript:;" class="remove">
                                <i class="icon-close"></i>
                            </a>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                            </div>
                        </form>
                    </li>
        ';
        return $hometag.self::renderItemsMy($items);
    }


    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItemsMy($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item)
        {
            if (!empty($item['items']))
            {
                $item['template'] = '<li><a href="javascript:openapp(\'{url}\',\'' . $item['id'] . '\',\'' . $item['label'] . '\')" class="nav-link">
                        <i class="icon-' . $item['icon'] . '"></i>
                        <span class="title">{label}</span>
                        </a></li>';
            }
            else
            {
                $item['template'] = '<a href="javascript:openapp(\'{url}\',\'' . $item['id'] . '\',\'' . $item['label'] . '\')" ><i class="menu-icon fa fa-' . (empty($item['icon']) ? 'leaf' : $item['icon']) . '"></i>{label}</a>';

            }
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active'])
            {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null)
            {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null)
            {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class))
            {
                if (empty($options['class']))
                {
                    $options['class'] = implode(' ', $class);
                }
                else
                {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            $menu = $this->renderItem($item);
            if (!empty($item['items']))
            {
                $menu .= strtr($this->submenuTemplate, [
                    '{items}' => $this->renderItemsMy($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }


        return implode("\n", $lines);
    }
}