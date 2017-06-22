<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
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

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        'name',
                        [
                            'attribute' => 'menuParent.name',
                            'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                                'class' => 'form-control', 'id' => null
                            ]),
                            'label' => Yii::t('rbac-admin', 'Parent'),
                        ],
                        'route',
                        'order',
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
                                        return Html::a('查看', Url::to(['menu/view','id'=>$model->id]), [
                                            'title' => Yii::t('yii', '赋权'),
                                            'class' => 'btn btn-outline btn-sm blue'
                                        ]);
                                    }
                            ]
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>
