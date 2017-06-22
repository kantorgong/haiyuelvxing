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

$this->title = '微信活动';
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
                'label' => '编号',
                'value' => function($data){return $data['id'];},
                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
            ],
            [
                    'attribute'=>'group_id',
                    'label' => '分组',
                    'value' => function ($data) {
                        if (!$data->group_id) return '-';
                        return $data->group->title;
                    },
                    'filter' => \common\models\activity\LotteryActiveGroup::groupList(),
                    'contentOptions' => ['style' => 'width: 20px;'],
                    'filterOptions' => ['style' => 'width: 20px;'],
            ],
            [
                'attribute'=>'act_name',
                'label' => '标题',
                'value' => $data['act_name'],
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'type',
                'label' => '活动类型',
                'value' => function ($data) {
                    if(1 == intval($data['type']))
                        return '大转盘';
                    elseif(2 == intval($data['type']))
                        return '刮刮卡';
                    elseif(3 == intval($data['type']))
                        return '福袋';
                    else
                        return '摇一摇';
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', ['' => '','1' => '大转盘', '2' => '刮刮卡', '3' => '福袋', '4' => '摇一摇'], ['class' => 'form-control']),
                'contentOptions' => ['style' => 'width: 20px;'],
                'filterOptions' => ['style' => 'width: 20px;'],
            ],
            [
                'attribute'=>'bonus',
                'label' => '是否红包活动',
                'format' => 'raw',
                'value' => function ($data) {
                    if(!$data['bonus'])
                        return '<span class="label label-grey">否</span>';
                    else
                        return '<span class="label label-success">是</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'bonus', ['' => '','0' => '否', '1' => '是'], ['class' => 'form-control']),
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'label'=>'可抽奖次数',
                'value' => function($data){return $data['draw_num'];},
                'headerOptions' => ['style' => 'text-align: left; width:100px;'],
            ],
            [
                'attribute'=>'status',
                'label' => '状态',
                'value' => function ($data) {
                    if(0 == intval($data['status']))
                        return '暂停';
                    elseif(1 == intval($data['status']))
                        return '进行中';
                    elseif(2 == intval($data['status']))
                        return '结束';
                    else
                        return '废弃';
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', ['' => '', '0' => '暂停', '1' => '进行中', '2' => '结束', '3' => '废弃'], ['class' => 'form-control']),
                'contentOptions' => ['style' => 'width: 30px;'],
                'filterOptions' => ['style' => 'width: 30px;'],
            ],
            [
                'attribute'=>'开始时间',
                'value' => function ($data) {
                    if(0 < intval($data['start_time']))
                        return date("Y-m-d H:i:s",  $data['start_time']);
                },
                'headerOptions' => ['style' => 'text-align: left; width:100px;'],
            ],
            [
                'attribute'=>'结束时间',
                'value' => function ($data) {
                    if(0 < intval($data['end_time']))
                        return date("Y-m-d H:i:s",  $data['end_time']);
                    else
                        return FALSE;
                },
                'headerOptions' => ['style' => 'text-align: left; width:100px;'],
            ],
            [
                    'class' => 'backend\components\grid\ActionColumn',
                    'template' => '{update}{winner}{copy}',
                    'headerOptions' => ['style' => 'text-align: left; width:100px;'],
                    'header' => '操作',
                    'buttons' => [
                            'winner' => function ($url, $data, $model)
                            {
                                return Html::a(
                                        '中奖信息',
                                        Url::toRoute(['winner', 'id' => $data['id']]),
                                        [
                                                'title' => Yii::t('yii', '查看中奖信息'),
                                                'class' => 'btn btn-outline btn-sm blue'
                                        ]);
                            },
                            'copy' => function ($url, $data, $model)
                            {
                                return Html::a('复制活动','#', [
                                        'title' => Yii::t('yii', '复制活动'),
                                        'class' => 'btn btn-outline btn-sm yellow',
                                        'onclick' => 'gridViewConfirm("确定要复制吗？", "'.$url.'");'
                                ]);
                            },
                    ]
            ],
		],
	]); ?>
    </div>
</div>