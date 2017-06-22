<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use components\widgets\Breadcrumbs;
use components\helper\CommonUtility;

$this->title = $parent['name'];
//$this->addBreadcrumb('字典分类', ['dictcategory/index']);
//$this->addBreadcrumb($category['name'] . '(' . $category['id'] . ')', ['dict/index', 'catid' => $category['id']]);
//array_pop($parents);
//foreach ($parents as $item)
//{
//    $this->addBreadcrumb($item->name, ['index', 'pid' => $item->id, 'catid' => $category['id']]);
//}
//$this->addBreadcrumb($parent['name']);

$this->params['breadcrumbs'] = $this->title;

//面包屑路径
$links = array ();
$linksOther = array ();
$catid = Yii::$app->request->getQueryParams()['catid'];
$pid = Yii::$app->request->getQueryParams()['pid'];
//字典路径数组
$dictpath = CommonUtility::getDictPath($catid, $pid);
if (is_array($dictpath))
{
    //根节点
    if (is_object($dictpath['home']))
    {
        $links = [
            [
                'label' => $dictpath['home']->name,
                'template' => "<li>{link}</li>\n",
                'url' => Url::to(['/admin/dict/index', 'catid' => $dictpath['home']->id])
            ]
        ];
    }
}
//根节点下的子节点
if (is_array($dictpath['other']))
{
    foreach ($dictpath['other'] as $dt)
    {
        if (is_object($dt))
        {
            $linksOtherarr = [
                [
                    'label' => $dt->name,
                    'template' => "<li>{link}</li>\n",
                    'url' => Url::to(['/admin/dict/index', 'pid' => $dt->id, 'catid' => $dt->category_id])
                ]
            ];
            //合并所有节点
            $linksOther = array_merge($linksOther, $linksOtherarr);
        }
    }
}
//合并根节点与其所有子节点
$links = array_merge($links, $linksOther);
?>


    <div class="page-bar">

            <?= Breadcrumbs::widget([
                'tag' => 'UL',
                'options' => ['id' => 'breadcrumb', 'class' => 'page-breadcrumb'],
                'itemTemplate' => "<li>{link}<i class='fa fa-circle'></i></li>",
                'links' => $links,
                'homeLink' => [
                    'label' => '首页',
                    'url' => '/admin/dictcategory/index'
                ],
            ]); ?>



    </div>


<div class="main-content-inner" style="width:99%">

    <div class="trail clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">
                <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                    ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Yii::$app->request->referrer . '"']) ?>
            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建字典' . $this->title, ['create', 'pid' => $pid, 'catid' => $catid], ['class' => 'btn blue']) ?>
        </div>
    </div>





    <table width="100%" class="table table-striped m-b-none dataTable">
        <tr class="tb_header">
            <th width="50px">ID</th>
            <th width="120px">名称</th>
            <th>值</th>
            <th width="80px">排序</th>
            <th width="300px">操作</th>
        </tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['value'] ?></td>
                <td><?php echo $row['sort_num'] ?></td>
                <td>
                    <?= Html::a('查看',
                        ['index', 'pid' => $row->id, 'catid' => $row->category_id],
                        ['title' => Yii::t('yii', '查看'), 'class' => 'btn btn-outline btn-sm blue']) ?>
                    <?= Html::a('新建',
                        ['create', 'pid' => $row->id, 'catid' => $row->category_id],
                        ['title' => Yii::t('yii', '新建'), 'class' => 'btn btn-outline btn-sm purple']) ?>
                    <?= Html::a('修改',
                        ['update', 'id' => $row->id, 'catid' => $row->category_id],
                        ['title' => Yii::t('yii', '修改'), 'class' => 'btn btn-outline btn-sm green']) ?>
                    <?php echo Html::a('删除',
                        '#',
                        ['title' => Yii::t('yii', '删除'),
                            'class' => 'btn btn-outline btn-sm red',
                            'onclick' => 'gridViewConfirm("确定要删除吗？", "' . Url::to(['delete', 'id' => $row->id, 'catid' => $row->category_id]) . '");'
                        ]
                    ); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="tbox">
        <div class="floatRight">
            <?php echo LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        </div>
    </div>
</div>

