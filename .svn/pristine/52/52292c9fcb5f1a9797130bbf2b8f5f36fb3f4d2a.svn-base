<?php
use yii\helpers\Html;
use backend\components\grid\GridView;
use components\helper\CommonUtility;

$this->title = '用户管理';
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">

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
                    'attribute' => 'rid',
                    'contentOptions' => ['style' => 'width: 50px;'],
                    'filterInputOptions' => ['style' => 'width: 50px', 'class' => 'form-control']
                ],
                'uid',
                [
                    'label' => '姓名',
                    'value' => function ($model) {
                        return $model->nickname->nickname;
                    },
                ],
                'day',
                [
                    'attribute' => 'image',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->image ? '<img src="'.$model->image.'" width="80" height="80">' : '-';
                    }
                ],
                'remark',
                [
                    'attribute' => 'insert_time',
                    'value' => function($model) {
                        return date('Y-m-d H:i:s', $model->insert_time);
                    }
                ]
            ],
        ]); ?>
    </div>
</div>