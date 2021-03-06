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
$wxsExtendStatus = \components\helper\CommonUtility::getDictsList('wx_extend_status', 0, true);
$this->title = '扩展列表';
?>
<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">

        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新增扩展', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
        </div>
    </div>
    <div class="table-header"></div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'kid',
                    'contentOptions' => ['style' => 'width: 80px;'],
                    'filterInputOptions' => ['class' => 'form-control', 'style' => 'width: 80px;'],
                ],
                'name',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function($model) {
                            $wxsExtendStatus = \components\helper\CommonUtility::getDictsList('wx_extend_status', 0, true);
                            $css = $model->status == 1 ? 'success' : 'default';
                            return '<span class="label label-'.$css.'">' . $wxsExtendStatus[$model->status] . '</span>';
                        },
                    'filter' => Html::activeDropDownList($searchModel, 'status', $wxsExtendStatus, ['class' => 'form-control','prompt' => '请选择']),
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
                    'class' => 'backend\components\grid\ActionColumn',
                    'header' => '操作',
                    'options' => ['width' => '50px;'],
                    'template' => '{update}',
                ],
            ]
        ]);
        ?>
    </div>
</div>