<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use backend\components\grid\GridView;
use mdm\admin\components\RouteRule;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Yii::$app->getAuthManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
switch($type)
{
    case 1: $this->title = '角色';break;
    case 2: $this->title = '权限';break;
}

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content-inner" style="width:99%">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn blue']) ?>
            </div>
        </div>
        <div class="portlet-body">
            <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'attribute' => 'name',
                            'label' => Yii::t('rbac-admin', 'Name'),
                        ],
                        [
                            'attribute' => 'ruleName',
                            'label' => Yii::t('rbac-admin', 'Rule Name'),
                            //'filter' => $rules
                        ],
                        [
                            'attribute' => 'description',
                            'label' => Yii::t('rbac-admin', 'Description'),
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'template' => '{priv} {update} {delete}',
                            'headerOptions' => [
                                'style' => 'text-align: left; width:200px;'
                            ],
                            'header' => '操作',
                            'buttons' => [
                                'priv' => function ($url, $model)
                                    {
                                        return Html::a('赋权', Url::to([$model->type == 1 ? 'role/view' : 'permission/view','id'=>$model->name]), [
                                            'title' => Yii::t('yii', '赋权'),
                                            'class' => 'btn btn-outline btn-sm blue'
                                        ]);
                                    }
                            ]
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>