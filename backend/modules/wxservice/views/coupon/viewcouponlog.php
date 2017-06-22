<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;
use components\helper\CommonUtility;
use yii\helpers\Url;

$this->title = '优惠券用户';
?>
<div class="main-content-inner" style="width:99%">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="page-header">
            <div class="pull-right tableTools-container">
                <button type="button" class="btn btn-default" onclick="window.location.href='<?=Url::to(['index'])?>'">
                    <i class="ace-icon fa fa-reply icon-only"></i>返回
                </button>
            </div>
            <h3 class="page-title"><?=$this->title?></h3>
        </div>
        <div class="portlet-body">
            <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'label' => '编号',
                            'value' => function ($data)
                            {
                                return $data['id'];
                            },
                            'contentOptions' => ['style' => 'width: 10px;']
                        ],
                        [
                            'attribute' => 'coupon_id',
                            'label' => '优惠券编号',
                            'value' => function ($data)
                            {
                                return $data['coupon_id'];
                            },
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'filterInputOptions' => ['style' => 'width:150px']
                        ],
                        [
                            'attribute' => 'userid',
                            'label' => '用户编号',
                            'value' => function ($data)
                            {
                                return $data['userid'];
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 80px;'],
                            'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                            'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                            'attribute'=>'open_id',
                            'label' => '微信OPENID',
                            'value' => function($data){return $data['open_id'];},
                            'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                            'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                            'attribute'=>'nickname',
                            'label' => '昵称',
                            'value' => function($data){return $data['nickname'];},
                            'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                            'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($model) {
                                $css = $model->status == 1 ? 'success' : 'default';
                                $value = $model->status ==1 ? '已领取' : '未领取';
                                return '<span class="label label-'.$css.'">' . $value . '</span>';
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status', ['' => '', '0' => '未领取', '1' => '已领取'], ['class' => 'form-control']),
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                            'attribute' => 'insert_time',
                            'label' => '添加时间',
                            'value' => function ($data)
                            {
                                return $data['insert_time'] && $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '-';
                            },
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterInputOptions' => ['style' => 'width:30px']
                        ],
                        [
                            'attribute' => 'operat_time',
                            'label' => '操作时间',
                            'value' => function ($data)
                            {
                                return $data['operat_time'] && $data['operat_time'] ? date("Y-m-d H:i:s", $data['operat_time']) : '-';
                            },
                            'contentOptions' => ['style' => 'width: 30px;'],
                            'filterInputOptions' => ['style' => 'width:30px']
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'template' => '{getit}',
                            'headerOptions' => ['style' => 'text-align: left; width:100px;'],
                            'header' => '操作',
                            'buttons' => [
                                'getit' => function ($url, $data, $model)
                                {
                                    return Html::a(
                                        '领取',
                                        Url::toRoute(['receive', 'id' => $data['id']]),
                                        [
                                            'title' => Yii::t('yii', '领取'),
                                            'class' => 'btn btn-outline btn-sm green'
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

