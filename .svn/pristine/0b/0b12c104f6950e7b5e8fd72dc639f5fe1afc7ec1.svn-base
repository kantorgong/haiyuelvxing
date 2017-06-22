<?php

/**
 * @filename index.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-21 15:30:41
 * @version 1.0
 * @copyright (c) 2016-3-21, 潇湘晨报（版权）
 * @access public 权限
 */
use yii\helpers\Html;
use components\helper\CommonUtility;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;
use components\XyXy;
use yii\helpers\Url;

$this->title = '车展贪吃蛇活动';
?>
<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon" style="display: none">
                        <input type="text" placeholder="Search ..." class="nav-search-input"
                               id="nav-search-input" autocomplete="off">
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div>
        </div>
        <div class="pull-left tableTools-container">

        </div>
    </div>
    <div class="table-header"></div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php echo GridView::widget([
		'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'open_id',
            'nickname',
            'total',
            'server_last_time',
            [
                    'attribute' => 'start_time',
                    'value' => function ($data)
                    {
                        return $data['start_time'] ? date("Y-m-d H:i:s", $data['start_time']) : '-';
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
                                    'name' => 'Search[modify_time_range]',
                                    'class' => 'form-control',
                                    'placeholder' => '选择时间段',
                                    'style' => 'width:190px;',
                                    'value' => Yii::$app->request->getQueryParams()['Search']['modify_time_range'],
                            ]
                    ]),
                    'contentOptions' => ['style' => 'width: 200px;'],
                    'filterOptions' => ['style' => 'width: 200px;'],
            ],
            [
                    'attribute' => 'insert_time',
                    'value' => function ($data)
                    {
                        return $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '';
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
            ]
		],
	]); ?>
    </div>
</div>