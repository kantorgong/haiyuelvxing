<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;

$this->title = '中奖记录';
?>
<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon" style="display: none">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off">
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('导出数据', Url::toRoute(['export', 'id' => Yii::$app->request->get('id')]), ['class' => 'btn btn-success btn-sm']) ?>
        </div>
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', ['class' => 'btn btn-white btn-success', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
        </div>
        <div class="clearfix" style="clear: both"></div>
        <h3 class="header smaller lighter green"></h3>
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
                                'attribute'=>'open_id',
                                'label' => '微信OPENID',
                                'value' => function($data){return $data['open_id'];},
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                                'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                                'attribute'=>'nickname',
                                'label' => '昵称',
                                'value' => function($data){return $data['nickname'];},
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                                'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                                'attribute'=>'name',
                                'label' => '姓名',
                                'value' => function($data){return $data['name'];},
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                                'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                                'attribute'=>'phone',
                                'label' => '手机号码',
                                'value' => function($data){return $data['phone'];},
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                                'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                                'attribute'=>'prize_id',
                                'label' => '奖项ID',
                                'value' => function($data){return $data['prize_id'];},
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                                'filterOptions' => ['style' => 'width: 30px;'],
                        ],
                        [
                                'label' => '奖项名称',
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                                'value' => function($data){
                                    return $data->prize->name;
                                },
                        ],
//                        [
//                                'label' => '红包金额(元)',
//                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
//                                'value' => function($data){
//                                    return $data->bonus_amount?round($data->bonus_amount/100, 2):0;
//                                },
//                        ],
                        [
                                'label' => '中奖时间',
                                'value' => function($data){if($data['insert_time'])return date("Y-m-d H:i:s", $data['insert_time']);else return '-';},
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                        ],
                        [
                                'label' => '领奖时间',
                                'value' => function($data){if($data['modify_time'])return date("Y-m-d H:i:s", $data['modify_time']);else return '-';},
                                'headerOptions' => ['style' => 'text-align: left; width:60px;'],
                        ],
                ],
        ]); ?>
    </div>
</div>
