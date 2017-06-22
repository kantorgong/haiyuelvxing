<?php
use yii\helpers\Html;
use backend\components\grid\GridView;
use components\helper\CommonUtility;

$this->title = '活动列表';
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建活动', ['create'], ['class' => 'btn blue']) ?>
        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'title',
                'type',
                'venue_id',
                'start_time',
                'enroll_num',
                [
                    'class' => 'backend\components\grid\ActionColumn',
                    'template' => '{dict} {update} {delete}',
                    'headerOptions' => [
                        'style' => 'text-align: left; width:400px;'
                    ],
                    'header'=>'操作',
                ],
            ],
        ]); ?>
    </div>
</div>