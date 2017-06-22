<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;

$redis = Yii::$app->redis;
$lotteryId = Yii::$app->request->get('id');
$groupId = Yii::$app->request->get('group_id');
$lottery = $redis->hget('lottery_group:' . $groupId, 'lottery_list:' . $lotteryId);
$lottery = \GuzzleHttp\json_decode($lottery, true);
$prize = $redis->hvals('lottery_list:' . $lotteryId);
$totalNum = $redis->get('lottery_statistics:times:' . $lotteryId);
$totalUser = $redis->get('lottery_statistics:user:' . $lotteryId);
$totalShare = $redis->get('lottery_statistics:share:' . $lotteryId);
$totalWin = $redis->get('lottery_statistics:win:' . $lotteryId);
$totalAmount = $redis->get('lottery_statistics:bonus_amount:' . $lotteryId);

?>
<div class="main-content-inner" style="width:99%">
    <div class="page-header">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
        </div>
        <h3 class="page-title">统计数据</h3>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value=""><?=$totalUser?:0?></span>
                    </div>
                    <div class="desc"> 抽奖人数 </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value=""><?=$totalNum?:0?></span></div>
                    <div class="desc"> 抽奖次数 </div>
                </div>
            </a>
        </div>
<!--        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">-->
<!--            <a class="dashboard-stat dashboard-stat-v2 green" href="#">-->
<!--                <div class="visual">-->
<!--                    <i class="fa fa-shopping-cart"></i>-->
<!--                </div>-->
<!--                <div class="details">-->
<!--                    <div class="number">-->
<!--                        <span data-counter="counterup" data-value="">--><?//=$totalWin?:0?><!--</span>-->
<!--                    </div>-->
<!--                    <div class="desc"> 中奖次数 </div>-->
<!--                </div>-->
<!--            </a>-->
<!--        </div>-->
<!--        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">-->
<!--            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">-->
<!--                <div class="visual">-->
<!--                    <i class="fa fa-globe"></i>-->
<!--                </div>-->
<!--                <div class="details">-->
<!--                    <div class="number">-->
<!--                        <span data-counter="counterup" data-value="">--><?//=$totalAmount?:0?><!--</span> </div>-->
<!--                    <div class="desc"> 中奖金额 </div>-->
<!--                </div>-->
<!--            </a>-->
<!--        </div>-->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
                <div class="visual">
                    <i class="fa fa-share"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value=""><?=$totalShare?:0?></span>
                    </div>
                    <div class="desc"> 分享次数 </div>
                </div>
            </a>
        </div>
    </div>
    <?php if ($prize):?>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-advance table-hover"><thead>
            <tr>
                <th>奖等</th>
                <th>中奖数量</th>
                <th>剩余数量</th>
                <th>中奖金额</th>
                <th>剩余金额</th>
            </thead>
            <tbody>
                <?php foreach ($prize as $p): ?>
                <?php
                    $rt[] = \GuzzleHttp\json_decode($p, true);
                ?>
                <?php endforeach; ?>
                <?php
                    usort($rt, function($a, $b) {
                        return ($a['id'] < $b['id']) ? -1 : 1;
                    })
                ?>
                <?php foreach ($rt as $arr): ?>
                <?php
                    $num = $redis->get('lottery_statistics:win:'.$arr['id'])?:0;
                    $amount = $redis->get('lottery_statistics:bonus_amount:'.$arr['id'])?:0;
                ?>
                <tr>
                    <td><?=$arr['name']?></td>
                    <td><?=$num?></td>
                    <td><?=$arr['num'] - $num?></td>
                    <td><?=$lottery['bonus'] ? $amount : '-'?></td>
                    <td><?=$lottery['bonus'] ? ($arr['bonus_random'] ? ($arr['bonus_amount'] - $amount) : '-') : '-'?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>