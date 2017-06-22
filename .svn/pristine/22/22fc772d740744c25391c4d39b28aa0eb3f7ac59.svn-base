<?php

/**
 * @filename _form.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 17:51:43
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use components\helper\CommonUtility;

?>
<!--左侧开始-->
<div class="main-content-inner" style="width:99%">
    <div class="portlet">
        <div class="page-header">
            <div class="pull-right tableTools-container">
                <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
            </div>
            <h3 class="page-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="portlet-body">
            <div class="form-horizontal">
            <?php
            $disabled = $model->isNewRecord ? null : 'disabled';
            $form = ActiveForm::begin(['id' => 'lottery-form']);
            ?>
                <div class="form-body" id="app">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab" aria-expanded="true"> 活动信息 </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_2" data-toggle="tab" aria-expanded="false" v-if="!(bonus_random && bonus)"> 奖品信息 </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_3" data-toggle="tab" aria-expanded="false"> 活动规则 </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_1_1">
                            <?=$form->field($model, 'act_name', [
                                            'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textInput(['maxlength' => true, 'class' => 'form-control'])
                            ?>
                            <?=
                            $form->field($model, 'group_id', [
                                            'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->dropDownList(
                                    \common\models\activity\LotteryActiveGroup::groupList(), ['prompt' => '请选择', 'class' => 'form-control']
                            )
                            ?>
                            <?=
                            $form->field($model, 'type', [
                                            'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->dropDownList(
                                    [
                                            '1' => '大转盘',
                                            '2' => '刮刮卡',
                                            '3' => '福袋',
                                            '4' => '摇一摇'
                                    ], ['prompt' => '请选择', 'class' => 'form-control', 'v-model' => 'type']
                            )
                            ?>
                            <?=
                            $form->field($model, 'mp_type', [
                                            'template' => '{label}
                                                                <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->dropDownList(
                                    ['2' => '潇湘晨报'], ['prompt' => '请选择', 'class' => 'form-control']
                            )
                            ?>
                            <?=
                            $form->field($model, 'silence', [
                                            'template' => '{label}
                                                                <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                    ]
                            )->dropDownList(
                                    ['0' => '否', '1' => '是'], ['prompt' => '请选择', 'class' => 'form-control']
                            )
                            ?>
                            <?=
                            $form->field($model, 'draw_num', [
                                            'template' => '{label}
                                                                <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textInput(['maxlength' => true, 'class' => 'form-control'])
                            ?>
                            <?=
                            $form->field($model, 'act_note', [
                                            'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textarea(['maxlength' => true, 'class' => 'form-control', 'rows' => 5])
                            ?>
                            <?=
                            $form->field($model, 'act_know', [
                                            'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textarea(['maxlength' => true, 'class' => 'form-control', 'rows' => 5])
                            ?>

                            <?php if ($model->start_time) $model->start_time = date('Y-m-d H:i', $model->start_time);
                            echo $form->field($model, 'start_time', [
                                            'template' => '{label}
                                                                <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control datetime-picker'
                            ])?>

                            <?php if ($model->end_time) $model->end_time = date('Y-m-d H:i', $model->end_time);
                            echo $form->field($model, 'end_time', [
                                            'template' => '{label}
                                                                <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control datetime-picker'
                            ])?>

                            <?=
                            $form->field($model, 'status', [
                                            'template' => '{label}
                                                                <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->dropDownList(
                                    ['0' => '暂停', '1' => '进行中', '2' => '终止', '3' => '废弃'],
                                    ['prompt' => '请选择', 'class' => 'form-control']
                            )
                            ?>

                            <?=
                            $form->field($model, 'share', [
                                    'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label>
                                                        <div class="col-sm-9"><small class="muted"></small>
                                                        <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                        </div>',
                                    'labelOptions' => ['class' => ''],
                            ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'mt-checkbox', 'type' => 'checkbox', 'v-model' => 'share'], $enclosedByLabel = FALSE)
                            ?>
                            <template v-if="share">
                                <?php
                                if(!$model->share_add_num) $model->share_add_num = 0;
                                echo $form->field($model, 'share_add_num', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                        ]
                                )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                ?>
                            </template>
                            <?=
                            $form->field($model, 'bonus', [
                                    'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label>
                                                        <div class="col-sm-9"><small class="muted"></small>
                                                        <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                        </div>',
                                    'labelOptions' => ['class' => ''],
                            ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'mt-checkbox', 'type' => 'checkbox', 'v-model' => 'bonus'], $enclosedByLabel = FALSE)
                            ?>

                            <template v-if="bonus">
                                <?=
                                $form->field($model, 'bonus_share', [
                                        'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label>
                                                        <div class="col-sm-9"><small class="muted"></small>
                                                        <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                        </div>',
                                        'labelOptions' => ['class' => ''],
                                ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'ace ace-switch ace-switch-5', 'type' => 'checkbox'], $enclosedByLabel = FALSE)
                                ?>
                            </template>
                            <template v-if="bonus">
                                <?=$form->field($model, 'bonus_send_name', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    <span class="help-inline col-xs-7 col-sm-7">
                                                                        <span class="middle">{hint}{error}</span>
                                                                    </span>
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                        ]
                                )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                ?>
                            </template>
                            <template v-if="bonus">
                                <?=$form->field($model, 'bonus_wishing', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    <span class="help-inline col-xs-7 col-sm-7">
                                                                        <span class="middle">{hint}{error}</span>
                                                                    </span>
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                        ]
                                )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                ?>
                            </template>
                            <template v-if="bonus">
                                <?=
                                $form->field($model, 'bonus_remark', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    <span class="help-inline col-xs-7 col-sm-7">
                                                                        <span class="middle">{hint}{error}</span>
                                                                    </span>
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                        ]
                                )->textarea(['maxlength' => true, 'class' => 'form-control', 'rows' => 5])
                                ?>
                            </template>
                            <template v-if="(bonus && type > 1)">
                                <?=
                                $form->field($model, 'bonus_random', [
                                        'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label>
                                                        <div class="col-sm-9"><small class="muted"></small>
                                                        <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                        </div>',
                                        'labelOptions' => ['class' => ''],
                                ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'ace ace-switch ace-switch-5', 'type' => 'checkbox', 'v-model' => 'bonus_random'], $enclosedByLabel = FALSE)
                                ?>
                            </template>
                            <template v-if="bonus_random && bonus">
                                <?php if(!$model->bonus_amount) $model->bonus_amount = 0;
                                echo $form->field($model, 'bonus_amount', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    <span class="help-inline col-xs-7 col-sm-7">
                                                                        <span class="middle">{hint}{error}</span>
                                                                    </span>
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                        ]
                                )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                ?>
                            </template>
                            <template v-if="bonus_random && bonus">
                                <?php if(!$model->max_amount) $model->max_amount = 0;
                                echo $form->field($model, 'max_amount', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    <span class="help-inline col-xs-7 col-sm-7">
                                                                        <span class="middle">{hint}{error}</span>
                                                                    </span>
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                        ]
                                )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                ?>
                            </template>
                            <template v-if="bonus_random && bonus">
                                <?php if(!$model->min_amount) $model->min_amount = 0;
                                echo $form->field($model, 'min_amount', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                        ]
                                )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                ?>
                            </template>
                            <template v-if="bonus_random && bonus">
                                <?php if(!$model->probability) $model->probability = 0;
                                echo $form->field($model, 'probability', [
                                                'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                        ]
                                )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                ?>
                            </template>
                        </div>
                        <div class="tab-pane fade" id="tab_1_2" v-if="!(bonus_random && bonus)">
                            <span v-on:click="addPrize"
                                  class="btn btn-success btn-sm popover-success"
                                  data-rel="popover"
                                  data-placement="right"
                                  data-original-title="<i class='ace-icon fa fa-check green'></i> Right Success">添加奖项</span>
                            <template v-for="(prize, index) in prizes">
                                <!--奖品模块-->
                                <div :id="'new_prize_'+index">
                                    <h3 class="header smaller lighter green" v-show="index"></h3>
                                    <span v-if="index" v-on:click="delPrize(index)" class="btn btn-warning btn-sm popover-warning" data-rel="popover" data-placement="left" data-original-title="<i class='ace-icon fa fa-exclamation-triangle orange'></i> Left Warning">删除</span>
                                    <input type="hidden" name="LotteryPrize[id][]" :value="prize.id">
                                    <div class="form-group field-lotteryprize-name">
                                        <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-name">奖项</label>
                                        <div class="col-sm-3">
                                            <input type="text" required id="lotteryprize-name" class="form-control" name="LotteryPrize[name][]" :value="prize.name">
                                        </div>
                                    </div>

                                    <div class="form-group field-lotteryprize-content">
                                        <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-content">奖品</label>
                                        <div class="col-sm-3">
                                            <input type="text" required id="lotteryprize-content" class="form-control" name="LotteryPrize[content][]" :value="prize.content">
                                        </div>
                                    </div>
                                    <div v-if="bonus">
                                        <div class="form-group field-lotteryprize-bonus_random">
                                            <label for="lotteryprize-bonus_random" class="col-sm-3 control-label">是否随机金额</label>
                                            <div class="col-sm-3">
                                                <select id="lotteryprize-bonus_random" name="LotteryPrize[bonus_random][]" class="form-control">
                                                    <option value="0">否</option>
                                                    <option value="1" :selected="prize.bonus_random == 1">是</option>
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group field-lotteryprize-bonus_amount">
                                            <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-bonus_amount">红包金额(分)</label>
                                            <div class="col-sm-3">
                                                <input type="text" id="lotteryprize-bonus_amount" class="form-control" name="LotteryPrize[bonus_amount][]" :value="prize.bonus_amount">
                                                <div class="help-block">
                                                    <div class="label label-default">随机金额红包此处为总金额。</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group field-lotteryprize-min_amount">
                                            <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-min_amount">最小红包金额(分)</label>
                                            <div class="col-sm-3">
                                                <input type="text" id="lotteryprize-min_amount" class="form-control" name="LotteryPrize[min_amount][]" :value="prize.min_amount">
                                                <div class="help-block"><div class="label label-default">随机金额红包请填写此项。</div></div>
                                            </div>
                                        </div>
                                        <div class="form-group field-lotteryprize-max_amount">
                                            <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-max_amount">最大红包金额(分)</label>
                                            <div class="col-sm-3">
                                                <input type="text" id="lotteryprize-max_amount" class="form-control" name="LotteryPrize[max_amount][]" :value="prize.max_amount">
                                                <div class="help-block"><div class="label label-default">随机金额红包请填写此项。</div></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group field-lotteryprize-num">
                                        <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num">实际数量</label>
                                        <div class="col-sm-3">
                                            <input type="text" required id="lotteryprize-num" class="form-control" name="LotteryPrize[num][]" :value="prize.num">
                                        </div>
                                    </div>


                                    <div class="form-group field-lotteryprize-num_show">
                                        <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num_show">显示数量</label>
                                        <div class="col-sm-3">
                                            <input type="text" required id="lotteryprize-num_show" class="form-control" name="LotteryPrize[num_show][]" :value="prize.num_show">
                                        </div>
                                    </div>


                                    <div class="form-group field-lotteryprize-probability">
                                        <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-probability">中奖概率(‱)</label>
                                        <div class="col-sm-3">
                                            <input type="text" required id="lotteryprize-probability" class="form-control" name="LotteryPrize[probability][]" :value="prize.probability">
                                        </div>
                                    </div>

                                </div>
                            </template>
                        </div>
                        <div class="tab-pane fade" id="tab_1_3">
                            <?=
                            $form->field($model, 'global_rule', [
                                    'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label>
                                                        <div class="col-sm-9"><small class="muted"></small>
                                                        <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                        </div>',
                                    'labelOptions' => ['class' => ''],
                            ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'mt-checkbox', 'type' => 'checkbox'], $enclosedByLabel = FALSE)
                            ?>
                            <?=$form->field($model, 'refuse', [
                                            'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textInput(['maxlength' => true, 'class' => 'form-control'])
                            ?>
                            <?=
                            $form->field($model, 'behavior', [
                                            'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textInput(['maxlength' => true, 'class' => 'form-control'])
                            ?>
                            <?=
                            $form->field($model, 'region', [
                                            'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->dropDownList(
                                    [
                                            '中国' => '中国',
                                            '湖南' => '湖南',
                                    ], ['prompt' => '请选择', 'class' => 'form-control']
                            )
                            ?>
                            <?=
                            $form->field($model, 'black', [
                                            'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                    <div class="label label-default">每行一条数据</div>
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textarea(['maxlength' => true, 'class' => 'form-control', 'rows' => 5])
                            ?>
                            <?=
                            $form->field($model, 'white', [
                                            'template' => '{label}
                                                               <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                    <div class="label label-default">每行一条数据</div>
                                                                </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                    ]
                            )->textarea(['maxlength' => true, 'class' => 'form-control', 'rows' => 5])
                            ?>
                            <div class="form-actions clearfix">
                                <hr>
                                <div class="col-md-offset-3 col-md-6">
                                    <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' : '<i class="ace-icon fa fa-pencil bigger-110"></i>修改', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--此处将JS提前，activeForm生成的js不生效。必须要先等vue执行完再执行其它的JS -->
                <script>
                    <?php
                    ob_start();
                    ?>

                    new Vue({
                        el: '#app',
                        data: {
                            share: <?=$model->share?:0?>,
                            bonus: <?=$model->bonus?:0?>,
                            bonus_random: <?=$model->bonus_random?:0?>,
                            prizes: <?=$prizes?\GuzzleHttp\json_encode($prizes):"[{id: 0, name: '', content: '', bonus_amount: 0, num: 0, num_show: 0, probability: '', bonus_random: 0, max_amount: 0, min_amount: 0}]";?>,
                            type: <?=$model->type?:0?>
                        },
                        methods: {
                            addPrize: function() {
                                this.prizes.push({id: 0, name: '', content: '', bonus_amount: 0, num: 0, num_show: 0, probability: '', bonus_random: 0, max_amount: 0, min_amount: 0});
                            },
                            delPrize: function(index) {
                                this.prizes.splice(index, 1);
                            }
                        }
                    });

                    <?php
                    $js = ob_get_clean();
                    $this->registerJs($js);
                    ?>
                </script>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    <?php
    ob_start();
    ?>

    $('.datetime-picker').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    }).on('changeDate', function (ev) {
        $(this).datetimepicker('hide');
    });

    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>


