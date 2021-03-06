<?php

/**
 * @filename index.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 16:27:24
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */
use yii\helpers\Html;
use components\helper\CommonUtility;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;
use components\XyXy;
use yii\helpers\Url;

$this->title = '常用报名表单管理';
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
            <?= Html::a('新建' . $this->title, ['create'], ['class' => 'btn btn-success btn-sm']) ?>
        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php echo GridView::widget([
		 'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'label' => '编号',
                'value' => $data['id'],
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 60px;'],
            ],
            [
                'attribute'=>'info_title',
                'label' => '字段标题',
                'value' => $data['info_title'],
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'info_name',
                'label' => 'name属性',
                'value' => $data['info_name'],
                'contentOptions' => ['style' => 'width: 100px;'],
                'filterOptions' => ['style' => 'width: 100px;'],
            ],
            [
                'attribute'=>'info_label',
                'label' => 'html标签',
                'value' => $data['info_label'],
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'info_type',
                'label' => 'type属性',
                'value' => $data['info_type'],
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'options',
                'label' => '选项',
                'value' => $data['options'],
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'is_use',
                'label' => '是否使用',
                'format' => 'raw',
                'value' => function ($data) {
                    if(0 < intval($data['is_use']))
                        return '<span class="label label-success">是</span>';
                    else
                        return '<span class="label label-default">否</span>';
                },
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'添加时间',
                'value' => function ($data) {
                    if(0 < intval($data['insert_time']))
                        return date("Y-m-d H:i:s",  $data['insert_time']);
                },
                'headerOptions' => [
                    'style' => 'text-align: left; width:100px;'
                ],
            ],
            [
                'attribute'=>'修改时间',
                'value' => function ($data) {
                    if(0 < intval($data['modify_time']))
                        return date("Y-m-d H:i:s",  $data['modify_time']);
                },
                'headerOptions' => [
                    'style' => 'text-align: left; width:100px;'
                ],
            ],
            [
                'class' => 'backend\components\grid\ActionColumn',
                'template' => '{update}',
                'headerOptions' => [
                    'style' => 'text-align: left; width:50px;'
                ],
                'header' => '操作',
                'buttons' => [
                    'view' => function ($url, $model)
                    {
                        return Html::a('<span class="ace-icon fa fa-eye"></span>', $url, [
                            'title' => Yii::t('yii', '预览'),
                            'style' => 'padding:0px 2px;white-space:nowrap; '
                        ]);
                    }
                ]
            ],
		],
	]); ?>
    </div>
</div>