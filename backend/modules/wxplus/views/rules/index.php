<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;
use components\helper\CommonUtility;

$this->title = '全局规则';
?>
<div class="main-content-inner" style="width:99%">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="portlet-title">
            <?php if (\common\models\redis\LotteryRules::find()->count() == 0): ?>
            <div class="caption">
                <?= Html::a('新建' . $this->title, ['create'], ['class' => 'btn blue']) ?>
            </div>
            <?php else:?>
            <h3>全局规则</h3>
            <?php endif; ?>
        </div>
        <div class="portlet-body">
            <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'id',
                        'black',
                        'white',
                        'behavior',
                        'refuse',
                        'region',
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'header' => '操作',
                            'options' => ['width' => '50px;'],
                            'template' => '{update}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>

