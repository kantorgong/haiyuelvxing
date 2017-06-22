<?php

use yii\helpers\Html;
use components\helper\CommonUtility;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;
use components\XyXy;
use yii\helpers\Url;

$ranges = new \yii\web\JsExpression("{
                    '今天'        : [Date.today(), Date.today()],
                    '昨天'    : [Date.today().add({ days: -1 }), Date.today().add({ days: -1 })],
                    '最近一周'  : [Date.today().add({ days: -6 }), Date.today()],
                    '最近30天' : [Date.today().add({ days: -29 }), Date.today()],
                    '本月'   : [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                    '本年'    : [Date.today().moveToMonth(0,-1).moveToFirstDayOfMonth(), Date.today()],
                    '上个月'   : [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
                }");

$callback = new \yii\web\JsExpression("function(){}");

$this->title = '用户列表';
?>
<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">

        </div>
        <div class="pull-left tableTools-container">

        </div>
    </div>
    <div class="table-header"></div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'uid',
                        'contentOptions' => ['style' => 'width: 100px;'],
                        'filterInputOptions' => ['class' => 'form-control', 'style' => 'width: 100px;'],
                    ],
                    'open_id',
                    'nickname',
                    [
                        'attribute' => 'sex',
                        'value' => function($model) {
                            return $model->sex == 1 ? '男' : ($model->sex == 2 ? '女' : '未知');
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'sex', [
                                '' => '',
                                '1' => '男',
                                '2' => '女',
                                '3' => '未知'
                            ], ['class' => 'form-control']),
                        'contentOptions' => ['style' => 'width: 20px;'],
                        'filterOptions' => ['style' => 'width: 20px;'],
                    ],
                    'province',
                    'city',
                    [
                            'attribute' => 'insert_time',
                            'value' => function ($data)
                            {
                                return $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '-';
                            },
                            'filter' => DateRangePicker::widget([
                                    'name' => 'drp',
                                    'callback' => $callback,
                                    'options' => [
                                            'ranges' => $ranges,
                                            'locale' => [
                                                    'firstDay' => 1
                                            ]
                                    ],
                                    'htmlOptions' => [
                                            'name' => 'Search[insert_time_range]',
                                            'class' => 'form-control',
                                            'placeholder' => '选择时间段',
                                            'style' => 'width:190px;',
                                            'value' => Yii::$app->request->getQueryParams()['Search']['insert_time_range'],
                                    ]
                            ]),
                            'contentOptions' => ['style' => 'width: 200px;'],
                            'filterOptions' => ['style' => 'width: 200px;'],
                    ],
                ]
            ]);
        ?>
    </div>
</div>