<?php
use yii\helpers\Html;
use backend\components\grid\GridView;
use components\helper\CommonUtility;

$this->title = '自定义变量';
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn blue']) ?>
        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'name',
                'value:ntext',
                [
                    'attribute' => 'data_type',
                    'value' => function ($data) {
                        return CommonUtility::getDataType($data->data_type);
                    }
                ],
                'note',
                // 'is_cache',

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



