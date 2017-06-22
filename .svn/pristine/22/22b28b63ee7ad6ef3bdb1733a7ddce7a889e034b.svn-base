<?php
use yii\helpers\Html;
use backend\components\grid\GridView;

$this->title = '角色';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">

            <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn btn-success btn-sm']) ?>

        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php echo GridView::widget([

            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [

                [
                    'attribute' => 'id',
                    'headerOptions' => [
                        'style' => 'text-align: center; width:60px;'
                    ],
                ],
                'name',
                [
                    'attribute' => 'disabled',
                    'value' => function ($data)
                    {
                        return ($data->disabled) ? '是' : '否';
                    }
                ],
                [
                    'class' => 'backend\components\grid\ActionColumn',
                    'template' => '{priv} {update} {delete}',
                    'headerOptions' => [
                        'style' => 'text-align: left; width:200px;'
                    ],
                    'header' => '操作',
                    'buttons' => [
                        'priv' => function ($url, $model)
                        {
                            return Html::a('<span class="ace-icon fa fa-users"></span>', $url, [
                                'title' => Yii::t('yii', '赋权'),
                                'style' => 'padding:0px 2px;white-space:nowrap; '
                            ]);
                        }
                    ]
                ],
            ],
        ]); ?>

    </div>
</div>


