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

$this->title = '报名管理';
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
    <div class="table-header"></div>
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
            'guid',
            [
                'attribute'=>'title',
                'label' => '标题',
                'value' => function($data){
                    return stripslashes($data['title']);
                },
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'报名开始时间',
                'value' => function ($data) {
                    if(0 < intval($data['start_time']))
                        return date("Y-m-d H:i:s",  $data['start_time']);
                },
                'contentOptions' => ['style' => 'width: 100px;'],
                'filterOptions' => ['style' => 'width: 100px;'],
            ],
            [
                'attribute'=>'报名截止时间',
                'value' => function ($data) {
                    if(0 < intval($data['end_time']))
                        return date("Y-m-d H:i:s",  $data['end_time']);
                },
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
                'filter' => Html::activeDropDownList($searchModel, 'is_use', ['' => '','0' => '否', '1' => '是'], ['class' => 'form-control']),
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
                    else
                        return '';
                },
                'headerOptions' => [
                    'style' => 'text-align: left; width:100px;'
                ],
            ],
            [
                'class' => 'backend\components\grid\ActionColumn',
                'template' => '{form}{update}{applyer}',
                'headerOptions' => [
                    'style' => 'text-align: left; width:50px;'
                ],
                'header' => '操作',
                'buttons' => [
//                    'form' => function ($url, $model)
//                    {
//                        return Html::a('<span class="ace-icon fa fa-eye"></span>', $url, [
//                            'title' => Yii::t('yii', '查看报名表单'),
//                            'style' => 'padding:0px 2px;white-space:nowrap; '
//                        ]);
//                    },
                    'applyer' => function ($url, $model)
                    {
                        return Html::a('报名信息',$url, [
                                'title' => Yii::t('yii', '报名信息'),
                                'class' => 'btn btn-outline btn-sm yellow'
                        ]);
                    },
                ]
            ],
		],
	]); ?>
    </div>
</div>