<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;


$this->title = '数据字典';

?>


<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn blue']) ?>
            <?= Html::a('刷新缓存', '#', ['class' => 'btn btn-white purple', 'id' => 'refreshdict']) ?>
        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                'id',
                'name',
                'note',
                [
                    'attribute' => 'is_sys',
                    'value' => function ($data) {
                        return ($data->is_sys) ? '是' : '否';
                    }
                ],
                [
                    'class' => 'backend\components\grid\ActionColumn',
                    'template' => '{dict} {update} {delete}',
                    'headerOptions' => [
                        'style' => 'text-align: left; width:400px;'
                    ],
                    'header'=>'操作',
                    'buttons' => [
                        'dict' => function ($url, $model) {
                            return Html::a('查看',['dict/index', 'catid' =>$model->id], [
                                'title' => Yii::t('yii', '查看数据'),
                                'class' => 'btn btn-outline btn-sm blue'
                            ]).Html::a('添加', ['dict/create', 'catid' =>$model->id], [
                                'title' => Yii::t('yii', '增加数据'),
                                'class' => 'btn btn-outline btn-sm purple'
                            ]);
                        }
                    ]
                ],
            ],

        ]); ?>
    </div>
</div>
<script>
   $(function()
       {
           $('#refreshdict').on('click',function(){
               gridViewConfirm('确定要刷新缓存吗？', '<?=Url::to('admin/dictcategory/refreshdict.html')?>');
           });
       }
   );
</script>

