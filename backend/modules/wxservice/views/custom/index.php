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
$wxsCustomStatus = \components\helper\CommonUtility::getDictsList('wx_custom_status', 0, true);
$this->title = '客户列表';
?>
<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">

        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新增客户', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
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
                'nick_name',
                'user_name',
                [
                    'attribute' => 'user_group',
                    'value' => function($model) {
                            return $model->user_group == 1 ? '内部用户' : '普通用户';
                        },
                    'filter' => Html::activeDropDownList($searchModel, 'user_group', [
                            '' => '',
                            '1' => '内部用户',
                            '2' => '普通用户',
                        ], ['class' => 'form-control']),
                    'contentOptions' => ['style' => 'width: 30px;'],
                    'filterOptions' => ['style' => 'width: 30px;'],
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function($model) {
                            $wxsCustomStatus = \components\helper\CommonUtility::getDictsList('wx_custom_status', 0, true);
//                            return $model->status == 1 ? '禁用' : '正常';
                            $css = $model->status == 1 ? 'default' : 'success';
                            return '<span class="label label-'.$css.'">' . $wxsCustomStatus[$model->status] . '</span>';

                        },
                    'filter' => Html::activeDropDownList($searchModel, 'status', array_merge([
                            '' => '',
                        ], $wxsCustomStatus), ['class' => 'form-control']),
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
                    'headerOptions' => ['style' => 'width:300px;'],
                    'template' => '{update}{view}',
                    'buttons' => [
                        'view' => function ($url, $data, $model)
                            {
                                return Html::a(
                                    '设置公众号',
                                    Url::toRoute(['view', 'id' => $data['uid']]),
                                    [
                                        'title' => Yii::t('yii', '设置公众号'),
                                        'class' => 'btn btn-outline btn-sm blue'
                                    ]);
                            }
                    ]
                ],
            ]
        ]);
        ?>
    </div>
</div>