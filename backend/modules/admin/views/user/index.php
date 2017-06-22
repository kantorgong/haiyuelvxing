<?php

use yii\helpers\Html;
use backend\components\grid\GridView;

$this->title = '用户';
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn btn-success btn-sm']) ?>
<!--            <button class="btn btn-success btn-sm" id="bootbox-regular">普通</button>-->
<!--            <button class="btn btn-info  btn-sm" id="bootbox-confirm">对话框</button>-->
<!--            <button class="btn btn-success  btn-sm" id="bootbox-options">表单</button>-->


        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'username',
//                'password',
                'name',
//                'encrypt',
                [
                    'attribute' => 'role_id',
                    'value' => function ($data) {
                        return $data->role->name;
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($data) {
                        return ($data->status) ? '是' : '否';
                    }
                ],
                // 'setting:ntext',
                'created_at:datetime',
                'updated_at:datetime',
                ['class' => 'backend\components\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>

