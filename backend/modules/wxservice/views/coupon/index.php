<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;
use components\helper\CommonUtility;
use yii\helpers\Url;

$this->title = '优惠券';
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
                            'attribute' => 'coupon_id',
                            'label' => '编号',
                            'value' => function ($data)
                            {
                                return $data['coupon_id'];
                            },
                            'contentOptions' => ['style' => 'width: 10px;'],
                            'filterInputOptions' => ['style' => 'width:10px'],
                            'filterOptions' => ['style' => 'width: 10px;'],
                        ],
                        [
                            'attribute' => 'coupon_guid',
                            'label' => 'GUID',
                            'value' => function ($data)
                            {
                                return $data['coupon_guid'];
                            },
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'filterInputOptions' => ['style' => 'width:150px'],
                            'filterOptions' => ['style' => 'width: 150px;'],
                        ],
                        [
                            'attribute' => 'title',
                            'label' => '名称',
                            'value' => function ($data)
                            {
                                return $data['title'];
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 80px;'],
                            'filterInputOptions' => ['style' => 'width:80px'],
                            'filterOptions' => ['style' => 'width: 80px;'],
                        ],
                        [
                            'attribute' => 'price',
                            'label' => '价值',
                            'value' => function ($data)
                            {
                                return $data['price'];
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 80px;'],
                            'filterInputOptions' => ['style' => 'width:80px'],
                            'filterOptions' => ['style' => 'width: 80px;'],
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($model) {
                                $css = $model->status == 1 ? 'success' : 'default';
                                $value = $model->status ==1 ? '启用' : '禁用';
                                return '<span class="label label-'.$css.'">' . $value . '</span>';
                            },
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                            'attribute' => 'depict',
                            'label' => '描述',
                            'value' => function ($data)
                            {
                                return $data['depict'];
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 80px;'],
                            'filterInputOptions' => ['style' => 'width:80px'],
                            'filterOptions' => ['style' => 'width: 80px;'],
                        ],
                        [
                            'attribute' => 'insert_time',
                            'label' => '添加时间',
                            'value' => function ($data)
                            {
                                return $data['insert_time'] && $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '-';
                            },
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterInputOptions' => ['style' => 'width:30px'],
                            'filterOptions' => ['style' => 'width: 30px;'],
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
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterInputOptions' => ['style' => 'width:30px'],
                            'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                            'attribute' => 'modify_time',
                            'label' => '修改时间',
                            'value' => function ($data)
                            {
                                return $data['modify_time'] && $data['modify_time'] ? date("Y-m-d H:i:s", $data['modify_time']) : '-';
                            },
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterInputOptions' => ['style' => 'width:30px'],
                            'filterOptions' => ['style' => 'width: 30px;'],
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
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterInputOptions' => ['style' => 'width:30px'],
                            'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'template' => '{update}{winner}{statistics}{copy}',
                            'headerOptions' => ['style' => 'text-align: left; width:100px;'],
                            'header' => '操作',
                            'buttons' => [
                                'update' => function ($url, $data, $model)
                                {
                                    return Html::a(
                                        '更新',
                                        Url::toRoute(['update', 'coupon_id' => $data['coupon_id']]),
                                        [
                                            'title' => Yii::t('yii', '更新'),
                                            'class' => 'btn btn-outline btn-sm green'
                                        ]);
                                },
                                'winner' => function ($url, $data, $model)
                                {
                                    return Html::a(
                                        '查看用户',
                                        Url::toRoute(['view-coupon-log', 'coupon_id' => $data['coupon_id']]),
                                        [
                                            'title' => Yii::t('yii', '查看用户'),
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

