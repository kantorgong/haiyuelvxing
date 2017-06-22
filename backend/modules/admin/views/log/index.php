<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;

$this->title = '日志';

// Define  ranges correctly
$ranges = new \yii\web\JsExpression("{
                    '今天'        : [Date.today(), Date.today()],
                    '昨天'    : [Date.today().add({ days: -1 }), Date.today().add({ days: -1 })],
                    '最近一周'  : [Date.today().add({ days: -6 }), Date.today()],
                    '最近30天' : [Date.today().add({ days: -29 }), Date.today()],
                    '本月'   : [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                    '本年'    : [Date.today().moveToMonth(0,-1).moveToFirstDayOfMonth(), Date.today()],
                    '上个月'   : [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
                }");

// Define empty callback fust for fun
$callback = new \yii\web\JsExpression("function(){}");
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建' . $this->title, ['create'], ['class' => 'btn btn-success btn-sm']) ?>
        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'userid',
                'username',
                'ip',
                'url',
                [
                    'attribute'=>'created_at',
                    'value' => function ($data) {
                        return date("Y-m-d H:i:s",  $data['created_at']);
                    },
                    'filter' => DateRangePicker::widget([
                        'name' => 'drp',
                        'callback' => $callback,
                        'options'  => [
                            'ranges' => $ranges,
                            'locale' => [
                                'firstDay' => 1
                            ]
                        ],
                        'htmlOptions' => [
                            'name'        => 'LogSearch[created_at_range]',
                            'class'       => 'form-control',
                            'placeholder' => '选择时间段',
                            'style'       => 'width:190px;',
                            'value'       => Yii::$app->request->getQueryParams()['LogSearch']['created_at_range'],
                        ]
                    ]),
                    'headerOptions' => [
                        'style' => 'text-align: center; width:100px;'
                    ],
                ],
                'depict',
                ['class' => 'backend\components\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>


