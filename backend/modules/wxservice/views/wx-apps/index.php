<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;
$this->title = '公众号';
?>
<div class="main-content-inner" style="width:99%">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <?= Html::a('新建' . $this->title, ['create'], ['class' => 'btn blue']) ?>
            </div>
        </div>
        <div class="portlet-body">
            <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'pid',
                        ],
                        'app_name',
                        'alias_name',
                        'app_id',
                        [
                            'attribute' => 'app_type',
                            'value' => function ($data)
                            {
                                $wxsAppTypeList = \components\helper\CommonUtility::getDictsList('wxs_app_type', 0, true);
                                return $wxsAppTypeList[$data['app_type']];
                            },
                        ],
                        [
                            'attribute' => 'belong_user_id',
                            'value' => function($model)
                            {
                                return $model->belong_user_id ? $model->belongor->user_name : '';
                            }
                        ],
                        [
                            'attribute' => 'disabled',
                            'format' => 'raw',
                            'value' => function($model)
                            {
                                if ($model->disabled)
                                {
                                    $css = 'default';
                                    $word = '禁用';
                                }
                                else
                                {
                                    $css = 'success';
                                    $word = '启用';
                                }
                                return '<span class="label label-'.$css.'">' . $word . '</span>';
                            }
                        ],
                        [
                            'attribute' => 'insert_time',
                            'label' => '添加时间',
                            'value' => function ($data)
                            {
                                return $data['insert_time'] && $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '-';
                            },
                        ],
                        [
                            'attribute' => 'insert_id',
                            'label' => '添加人',
                            'value' => function ($model)
                            {
                                if (!$model->insert_id) return '-';
                                return $model->insertor->name;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'modify_time',
                            'label' => '修改时间',
                            'value' => function ($data)
                            {
                                return $data['modify_time'] && $data['modify_time'] ? date("Y-m-d H:i:s", $data['modify_time']) : '-';
                            },
                        ],
                        [
                            'attribute' => 'modify_id',
                            'label' => '修改人',
                            'value' => function ($model)
                            {
                                if (!$model->modify_id) return '-';
                                return $model->modifior->name;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'header' => '操作',
                            'headerOptions' => ['style' => 'width:200px;'],
                            'template' => '{update}{set}',
                            'buttons' => [
                                'set' => function ($url, $data, $model)
                                    {
                                        return Html::a(
                                            '配置扩展',
                                            Url::toRoute(['extend', 'id' => $data['pid']]),
                                            [
                                                'title' => Yii::t('yii', '设置公众号'),
                                                'class' => 'btn btn-outline btn-sm blue'
                                            ]);
                                    }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>

