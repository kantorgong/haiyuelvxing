<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;
$this->title = '用户';
?>

<div class="main-content-inner" style="width:99%">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn blue']) ?>
            </div>
        </div>
        <div class="portlet-body">
            <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'id',
                        'username',
                        'name',
                        [
                            'attribute' => 'status',
                            'label' => '状态',
                            'value' => function ($model)
                            {
                                return ($model->status) ? '是' : '否';
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 50px;'],
                            'filterInputOptions' => ['style' => 'width:50px'],
                            'filterOptions' => ['style' => 'width: 50px;'],
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'template' => '{priv} {update} {delete}',
                            'headerOptions' => [
                                'style' => 'text-align: left; width:230px;'
                            ],
                            'header' => '操作',
                            'buttons' => [
                                'priv' => function ($url, $data)
                                {
                                    return Html::a('赋权', Url::to(['assignment/view','id'=>$data->id]), [
                                        'title' => Yii::t('yii', '赋权'),
                                        'url' => $url,
                                        'class' => 'btn btn-outline btn-sm blue'
                                    ]);
                                }
                            ]
                        ],
                    ],
                ]); ?>

            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>