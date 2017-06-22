<?php

namespace common\widgets;

use yii\helpers\ArrayHelper;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\VarDumper;

class MenuWidget extends \yii\widgets\Menu
{
    public $activeCssClass =' active ';
    public $firstItemCssClass = ' start active ';
	public function init()
    {
        $this->items = $this->getItems();
    }

    private function getItems()
    {
		$menus = \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id);
        return $menus;

    }

    protected function renderItems($items)
    {

        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item)
        {
            if (!empty($item['items']))
            {
                //父菜单
                $item['template'] = '<a href="javascript:;"   class="nav-link nav-toggle">
                       <i class="fa fa-' . $item['icon'] . '"></i>
                        <span class="title">{label}</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                        </a>';
            }
            else
            {
                //子菜单
                $item['template'] = '<a href="#" onclick="openapp(\'{url}\',\'' . $item['id'] . '\',\'' . $item['label'] . '\',this)"   class="nav-link nav-toggle"><i class="fa fa-' . (empty($item['icon']) ? 'icon' : $item['icon']) . '" ></i><span class="title">  {label}</span></a>';
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
                    '{items}' => $this->renderItems($item['items']),
                ]);

            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

	protected function renderItem($item)
    {

        if (isset($item['url']))
		{
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
				'{icon}' => $item['icon'],
            ]);
        }
		else
		{
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
				'{label}' => $item['label'],
				'{icon}' => $item['icon'],
				]);
        }
    }

    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }

    // @todo 注释掉
/*	protected function isItemActive($item)
	{
		$menus_friends = [
			'/admin/user/index' => ['admin/user/view', 'admin/user/create', 'admin/user/update', 'admin/assignment/view'],
			'/admin/assignment/index' => ['admin/assignment/', 'admin/assignment/revoke', 'admin/assignment/view', 'admin/assignment/',],
			'/admin/role/index' => ['admin/role/create', 'admin/role/update', 'admin/role/view', ],
			'/admin/permission/index' => ['admin/permission/create', 'admin/permission/update', 'admin/permission/view'],
			'/admin/rule/index' => ['admin/rule/view', 'admin/rule/create', 'admin/rule/update'],
			'/admin/menu/index' => ['admin/menu/create', 'admin/menu/view', 'admin/menu/update'],
            '/oto/building/index' => ['oto/building/create', 'oto/building/update', 'oto/building/view'],
			'/oto/school/index' => ['oto/school/create', 'oto/school/update', 'oto/school/view'],
			'/oto/store/index' => ['oto/store/create', 'oto/store/update', 'oto/store/view'],
			'/oto/category/index' => ['oto/category/create', 'oto/category/update', 'oto/category/view'],
            '/oto/goods/index' => ['oto/goods/create', 'oto/goods/update', 'oto/goods/view'],
		];

		if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
			foreach($menus_friends as $key => $menu)
			{
				if(in_array(Yii::$app->requestedAction->uniqueId, $menu) && $key === $item['url'][0])
				{
					return true;
				}
			}
			$route = Yii::getAlias($item['url'][0]);
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
	}*/
}
