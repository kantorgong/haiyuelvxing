<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;

$this->title = '中奖记录';
?>
<div class="main-content-inner" style="width:99%">
    <div class="page-header">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
        </div>
        <h3 class="page-title">中奖信息</h3>
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-advance table-hover"><thead>
            <tr>
                <th><a @click="order('id')">编号</a></th>
                <th>微信OPENID</th>
                <th>昵称</th>
                <th><a @click="order('prize_id')">奖项ID</a></th>
                <th><a @click="order('bonus_amount')">红包金额（元）</a></th>
                <th>中奖时间</th>
                <th><a @click="order('get_time')">领奖时间</a></th>
                <th><a @click="order('is_fail')">是否成功</a></th>
            </thead>
            <tbody>
                <tr v-for="item in list">
                    <td v-html="item.id"></td>
                    <td v-html="item.open_id"></td>
                    <td v-html="item.nickname"></td>
                    <td v-html="item.prize_id"></td>
                    <td v-html="item.bonus_amount/100"></td>
                    <td v-html="toDate(item.insert_time)"></td>
                    <td v-html="toDate(item.get_time)"></td>
                    <td v-html="failStatus(item.is_fail)"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    <?php
    ob_start();
    ?>
    var id = <?=Yii::$app->request->get('id')?>;
    var vm = new Vue({
        el: '#dynamic-table_wrapper',
        data: {
            list: [],
            idAsc: 1,
            bonusAsc: 1,
            prizeAsc: 1,
            timeAsc: 1,
            failAsc: 1
        },
        created: function() {
            $.ajax({
                type: 'POST',
                url: '/wxplus/draw/winner-list.html',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.data.length > 0) {
                        vm.list = data.data;
                        vm.list.sort(function(a, b) {
                            return b.id-a.id
                        });
                        return true;
                    }
                }
            });
        },
        methods: {
            order: function(field) {
                var asc = 1;
                if (field == 'id') {
                    asc = this.idAsc;
                    this.idAsc = -this.idAsc + 1;
                }
                else if (field == 'bonus_amount') {
                    asc = this.bonusAsc;
                    this.bonusAsc = -this.bonusAsc + 1;
                }
                else if (field == 'get_time') {
                    asc = this.timeAsc;
                    this.timeAsc = -this.timeAsc + 1;
                }
                else {
                    asc = this.failAsc;
                    this.failAsc = -this.failAsc + 1;
                }
                vm.list.sort(function(a, b) {
                    if (asc == 1)
                        return b[field]-a[field];
                    else
                        return a[field]-b[field];
                });
            },
            toDate: function(time) {
                if (!time || time == 0) return '-';
                return new Date(parseInt(time) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
            },
            failStatus: function(status) {
                if (status == 0) {
                    return '<label class="label label-success">成功</label>';
                }
                else {
                    return '<label class="label label-danger">失败</label>';
                }
            }
        }
    });

    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>
