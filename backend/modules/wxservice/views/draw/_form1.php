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
use yii\bootstrap\ActiveForm;
use components\helper\CommonUtility;
$this->registerJsFile('https://cdn.bootcss.com/vue/2.0.0-beta.1/vue.min.js');
$this->registerJsFile(Yii::getAlias('@web') . '/theme/ace/assets/js/date-time/moment.js');
$this->registerJsFile(Yii::getAlias('@web') . '/theme/ace/assets/js/date-time/bootstrap-datetimepicker.js');
$this->registerCssFile(Yii::getAlias('@web') . '/theme/ace/assets/css/bootstrap-datetimepicker.css');
?>
<script src="<?= Yii::getAlias('@web') ?>/theme/ace/assets/js/date-time/moment.js"></script>
<link href="<?= Yii::getAlias('@web') ?>/theme/ace/assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?= Yii::getAlias('@web') ?>/theme/ace/assets/js/date-time/bootstrap-datetimepicker.js"></script>

<!--左侧开始-->
<div class="col-xs-12" id="app">
    <div class="page-header">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', ['class' => 'btn btn-white btn-success', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
        </div>
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="form-horizontal">
        <?php
        $disabled = $model->isNewRecord ? null : 'disabled';
        $form = ActiveForm::begin([]);
        ?>
        <div class="col-sm-11 widget-container-col ui-sortable" style="min-height: 172px;">
            <div class="widget-box transparent ui-sortable-handle" style="opacity: 1; z-index: 0;">
                <div class="widget-header">
                    <div class="widget-toolbar no-border">
                        <ul class="nav nav-tabs" id="myTab2">
                            <li class="active"><a data-toggle="tab" href="#home1" aria-expanded="true">活动信息</a></li>
                            <li class=""><a data-toggle="tab" href="#home2" aria-expanded="false">奖品信息</a></li>
                        </ul>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main padding-12 no-padding-left no-padding-right">
                        <div class="tab-content padding-4">
                            <div id="home1" class="tab-pane active">
                                <!-- #section:custom/scrollbar.horizontal -->
                                <div class="scrollable-horizontal ace-scroll">
                                    <div class="scroll-track scroll-hz scroll-top" style="display: none;">
                                        <div class="scroll-bar"></div>
                                    </div>
                                    <div class="scroll-content">
                                        <!--活动模块-->
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'act_name', [
                                                'template' => '{label}
                                                    <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'type', [
                                                'template' => '{label}
                                                    <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->dropDownList(
                                                    ['1' => '大转盘', '2' => '刮刮卡', '3' => '福袋', '4' => '摇一摇'], ['prompt' => '请选择', 'class' => 'col-xs-5 col-sm-5']
                                            )
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'mp_type', [
                                                            'template' => '{label}
                                                    <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                        <span class="col-xs-12 col-sm-7">
                                                            <span class="middle label label-grey">红包抽奖必须选择有味公众号</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->dropDownList(
                                                    ['1' => '有味', '2' => '潇湘晨报'], ['prompt' => '请选择', 'class' => 'col-xs-5 col-sm-5']
                                            )
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'silence', [
                                                            'template' => '{label}
                                                    <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->dropDownList(
                                                    ['0' => '否', '1' => '是'], ['prompt' => '请选择', 'class' => 'col-xs-5 col-sm-5']
                                            )
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'draw_num', [
                                                'template' => '{label}
                                                    <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'act_note', [
                                                'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textarea(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5', 'rows' => 5])
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'act_know', [
                                                'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textarea(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5', 'rows' => 5])
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'status', [
                                                'template' => '{label}
                                                    <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->dropDownList(
                                                    ['0' => '暂停', '1' => '进行中', '2' => '终止', '3' => '废弃'], ['prompt' => '请选择', 'class' => 'col-xs-5 col-sm-5']
                                            )
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'share', [
                                                'template' => '<label class="col-sm-3 control-label no-padding-right">{label}</label>
                                                            <div class="col-sm-9">
                                                                {input}<span class="lbl"></span>
                                                            </div>',
                                                'labelOptions' => ['class' => ''],
                                            ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'ace ace-switch ace-switch-5', 'type' => 'checkbox', 'v-model' => 'share'], $enclosedByLabel = FALSE)
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="share">
                                            <?php
                                            if(!$model->share_add_num) $model->share_add_num = 0;
                                            echo $form->field($model, 'share_add_num', [
                                                'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?=
                                            $form->field($model, 'bonus', [
                                                    'template' => '<label class="col-sm-3 control-label no-padding-right">{label}</label>
                                                            <div class="col-sm-9">
                                                                {input}<span class="lbl"></span>
                                                            </div>',
                                                    'labelOptions' => ['class' => ''],
                                            ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'ace ace-switch ace-switch-5', 'type' => 'checkbox', 'v-model' => 'bonus'], $enclosedByLabel = FALSE)
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus">
                                            <?=
                                            $form->field($model, 'bonus_share', [
                                                    'template' => '<label class="col-sm-3 control-label no-padding-right">{label}</label>
                                                            <div class="col-sm-9">
                                                                {input}<span class="lbl"></span>
                                                            </div>',
                                                    'labelOptions' => ['class' => ''],
                                            ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'ace ace-switch ace-switch-5', 'type' => 'checkbox'], $enclosedByLabel = FALSE)
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus">
                                            <?=$form->field($model, 'bonus_send_name', [
                                                            'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus">
                                            <?=$form->field($model, 'bonus_wishing', [
                                                            'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus">
                                            <?=
                                            $form->field($model, 'bonus_remark', [
                                                            'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textarea(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5', 'rows' => 5])
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus">
                                            <?=
                                            $form->field($model, 'bonus_random', [
                                                    'template' => '<label class="col-sm-3 control-label no-padding-right">{label}</label>
                                                            <div class="col-sm-9">
                                                                {input}<span class="lbl"></span>
                                                            </div>',
                                                    'labelOptions' => ['class' => ''],
                                            ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'ace ace-switch ace-switch-5', 'type' => 'checkbox', 'v-model' => 'bonus_random'], $enclosedByLabel = FALSE)
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus_random && bonus">
                                            <?=$form->field($model, 'bonus_amount', [
                                                            'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus_random && bonus">
                                            <?=$form->field($model, 'max_amount', [
                                                            'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus_random && bonus">
                                            <?=$form->field($model, 'min_amount', [
                                                            'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                        <div class="form-group" v-show="bonus_random && bonus">
                                            <?=$form->field($model, 'probability', [
                                                            'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                    ]
                                            )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="home2" class="tab-pane">
                                <div class="scrollable ace-scroll" data-size="100" data-position="left" style="position: relative;">
                                    <div class="scroll-track scroll-active" style="display: block; height: 300px;"><div class="scroll-bar" style=""></div></div>
                                    <div class="scroll-content" id="home2prizes">
                                    <?php if(!$disabled): ?>
                                        <div class="clearfix" style="clear: both">
                                            <span v-on:click="addPrize" class="btn btn-success btn-sm popover-success" data-rel="popover" data-placement="right" data-original-title="<i class='ace-icon fa fa-check green'></i> Right Success">添加奖项</span>
                                        </div>
                                            <!--奖品模块-->
                                            <div class="form-group">
                                                <?=
                                                $form->field($prize_mod, 'name[]', [
                                                    'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                        ]
                                                )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?=
                                                $form->field($prize_mod, 'content[]', [
                                                                'template' => '{label}
                                                       <div class="col-sm-9">
                                                            {input}
                                                            <span class="help-inline col-xs-7 col-sm-7">
                                                                <span class="middle">{hint}{error}</span>
                                                            </span>
                                                        </div>',
                                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                        ]
                                                )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                                ?>
                                            </div>
                                            <div class="form-group" v-show="bonus">
                                                <?=
                                                $form->field($prize_mod, 'bonus_amount[]', [
                                                                'template' => '{label}
                                                           <div class="col-sm-9">
                                                                {input}
                                                                <span class="help-inline col-xs-7 col-sm-7">
                                                                    <span class="middle">{hint}{error}</span>
                                                                </span>
                                                            </div>',
                                                                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                        ]
                                                )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?=
                                                $form->field($prize_mod, 'num[]', [
                                                    'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                        ]
                                                )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?=
                                                $form->field($prize_mod, 'num_show[]', [
                                                    'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                        ]
                                                )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?=
                                                $form->field($prize_mod, 'probability[]', [
                                                    'template' => '{label}
                                                   <div class="col-sm-9">
                                                        {input}
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle">{hint}{error}</span>
                                                        </span>
                                                    </div>',
                                                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                                                        ]
                                                )->textInput(['maxlength' => true, 'class' => 'col-xs-5 col-sm-5'])
                                                ?>
                                            </div>
                                    <?php elseif(!empty($prizes)): ?>
                                        <div style="padding: 10px 0;"><span v-on:click="addPrize" class="btn btn-success btn-sm popover-success" data-rel="popover" data-placement="right" data-original-title="<i class='ace-icon fa fa-check green'></i> Right Success">添加奖项</span></div>
                                        <?php foreach ($prizes as $key => $prize): ?>
                                            <?php if($key): ?>
                                                <h3 class="header smaller lighter green"></h3>
                                            <?php endif; ?>
                                            <!--奖品模块-->
                                            <div id="new_prize_<?php echo ($prize->id * 10);?>">
                                            <span onclick="$('#new_prize_<?php echo ($prize->id * 10);?>').remove();return true;" class="btn btn-warning btn-sm popover-warning" data-rel="popover" data-placement="left" data-original-title="<i class='ace-icon fa fa-exclamation-triangle orange'></i> Left Warning">删除</span>
                                            <div class="form-group">
                                                <div class="form-group field-lotteryprize-name required">
                                                    <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-name">奖项</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="lotteryprize-name" class="col-xs-5 col-sm-5" name="LotteryPrize[name][]" value="<?=$prize->name ?>">
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle"><p class="help-block help-block-error"></p></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group field-lotteryprize-content required">
                                                    <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-content">奖品</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="lotteryprize-content" class="col-xs-5 col-sm-5" name="LotteryPrize[content][]" value="<?=$prize->content ?>">
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle"><p class="help-block help-block-error"></p></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" v-show="bonus">
                                                <div class="form-group field-lotteryprize-bonus_amount">
                                                    <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-bonus_amount">红包总额(分)</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="lotteryprize-bonus_amount" class="col-xs-5 col-sm-5" name="LotteryPrize[bonus_amount][]" value="<?=$prize->bonus_amount ?>">
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle"><p class="help-block help-block-error"></p></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group field-lotteryprize-num required">
                                                    <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num">实际数量</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="lotteryprize-num" class="col-xs-5 col-sm-5" name="LotteryPrize[num][]" value="<?=$prize->num ?>">
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle"><p class="help-block help-block-error"></p></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group field-lotteryprize-num_show required">
                                                    <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num_show">显示数量</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="lotteryprize-num_show" class="col-xs-5 col-sm-5" name="LotteryPrize[num_show][]" value="<?=$prize->num_show ?>">
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle"><p class="help-block help-block-error"></p></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group field-lotteryprize-probability required">
                                                    <label class="col-sm-3 control-label no-padding-right" for="lotteryprize-probability">中奖概率</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="lotteryprize-probability" class="col-xs-5 col-sm-5" name="LotteryPrize[probability][]" value="<?=$prize->probability ?>">
                                                        <span class="help-inline col-xs-7 col-sm-7">
                                                            <span class="middle"><p class="help-block help-block-error"></p></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php elseif(empty($prizes)):?>
                                            <span onclick="addPrize();" class="btn btn-success btn-sm popover-success" data-rel="popover" data-placement="right" data-original-title="<i class='ace-icon fa fa-check green'></i> Right Success">添加奖项</span>
                                            <div class="scroll-content" id="home2prizes"></div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                                <div class="clearfix form-actions" style="clear: both">
                                    <div class="col-md-offset-3 col-md-9">
                                        <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' : '<i class="ace-icon fa fa-pencil bigger-110"></i>修改', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-success']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script language="javascript">
    <?php
    ob_start();
    ?>

    var prize = 2;

    new Vue({
        el: '#app',
        data: {
            share: <?=$model->share?:0?>,
            bonus: <?=$model->bonus?:0?>,
            bonus_random: <?=$model->bonus_random?:0?>
        },
        methods: {
            addPrize : function () {
                var html = '<div id="new_prize_' + prize + '">' +
                        '<span onclick="$(\'#new_prize_' + prize + '\').remove();return true;" class="btn btn-warning btn-sm popover-warning" data-rel="popover" data-placement="left" data-original-title="<i class=\'ace-icon fa fa-exclamation-triangle orange\'></i> Left Warning">删除</span>' +
                        '<h3 class="header smaller lighter green"></h3>' +
                        '<div class="form-group">' +
                        '<div class="form-group field-lotteryprize-name required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-name">奖项</label>' +
                        '<div class="col-sm-9">' +
                        '<input type="text" id="lotteryprize-name" class="col-xs-5 col-sm-5" name="LotteryPrize[name][]">' +
                        '<span class="help-inline col-xs-7 col-sm-7">' +
                        '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<div class="form-group field-lotteryhongbao-content required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryhongbao-content">奖品</label>' +
                        '<div class="col-sm-9">' +
                        '<input type="text" id="lotteryprize-content" class="col-xs-5 col-sm-5" name="LotteryPrize[content][]">' +
                        '<span class="help-inline col-xs-7 col-sm-7">' +
                        '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group" v-show="bonus">' +
                        '<div class="form-group field-lotteryprize-bonus_amount">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-bonus_amount">红包总额(分)</label>' +
                        '<div class="col-sm-9">' +
                        '<input type="text" id="lotteryprize-bonus_amount" class="col-xs-5 col-sm-5" name="LotteryPrize[bonus_amount][]">' +
                        '<span class="help-inline col-xs-7 col-sm-7">' +
                        '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<div class="form-group field-lotteryprize-num required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num">实际数量</label>' +
                        '<div class="col-sm-9">' +
                        '<input type="text" id="lotteryprize-num" class="col-xs-5 col-sm-5" name="LotteryPrize[num][]">' +
                        '<span class="help-inline col-xs-7 col-sm-7">' +
                        '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<div class="form-group field-lotteryprize-num_show required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num_show">显示数量</label>' +
                        '<div class="col-sm-9">' +
                        '<input type="text" id="lotteryprize-num_show" class="col-xs-5 col-sm-5" name="LotteryPrize[num_show][]">' +
                        '<span class="help-inline col-xs-7 col-sm-7">' +
                        '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<div class="form-group field-lotteryprize-probability required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-probability">中奖概率</label>' +
                        '<div class="col-sm-9">' +
                        '<input type="text" id="lotteryprize-probability" class="col-xs-5 col-sm-5" name="LotteryPrize[probability][]">' +
                        '<span class="help-inline col-xs-7 col-sm-7">' +
                        '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                $("#home2prizes").append(html);
                prize++;
            }
        }
    });

    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>

<script>

    $(function() {
        $('#lotterylist-start_time').datetimepicker().next().on('click', function () {
            $(this).prev().focus();
        });
        $('#lotterylist-end_time').datetimepicker().next().on('click', function () {
            $(this).prev().focus();
        });
    });

    var prize1 = 2;

    function addPrize1()
    {
        var html = '<div id="new_prize_' + prize + '">' +
                '<span onclick="$(\'#new_prize_' + prize + '\').remove();return true;" class="btn btn-warning btn-sm popover-warning" data-rel="popover" data-placement="left" data-original-title="<i class=\'ace-icon fa fa-exclamation-triangle orange\'></i> Left Warning">删除</span>' +
                '<h3 class="header smaller lighter green"></h3>' +
                '<div class="form-group">' +
                    '<div class="form-group field-lotteryprize-name required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-name">奖项</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" id="lotteryprize-name" class="col-xs-5 col-sm-5" name="LotteryPrize[name][]">' +
                            '<span class="help-inline col-xs-7 col-sm-7">' +
                                '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                            '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<div class="form-group field-lotteryhongbao-content required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryhongbao-content">奖品</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" id="lotteryprize-content" class="col-xs-5 col-sm-5" name="LotteryPrize[content][]">' +
                            '<span class="help-inline col-xs-7 col-sm-7">' +
                                '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                            '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="form-group" v-show="bonus">' +
                    '<div class="form-group field-lotteryprize-bonus_amount">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-bonus_amount">红包总额(分)</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" id="lotteryprize-bonus_amount" class="col-xs-5 col-sm-5" name="LotteryPrize[bonus_amount][]">' +
                            '<span class="help-inline col-xs-7 col-sm-7">' +
                                '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                            '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<div class="form-group field-lotteryprize-num required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num">实际数量</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" id="lotteryprize-num" class="col-xs-5 col-sm-5" name="LotteryPrize[num][]">' +
                            '<span class="help-inline col-xs-7 col-sm-7">' +
                                '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                            '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<div class="form-group field-lotteryprize-num_show required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-num_show">显示数量</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" id="lotteryprize-num_show" class="col-xs-5 col-sm-5" name="LotteryPrize[num_show][]">' +
                            '<span class="help-inline col-xs-7 col-sm-7">' +
                                '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                            '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<div class="form-group field-lotteryprize-probability required">' +
                        '<label class="col-sm-3 control-label no-padding-right" for="lotteryprize-probability">中奖概率</label>' +
                        '<div class="col-sm-9">' +
                            '<input type="text" id="lotteryprize-probability" class="col-xs-5 col-sm-5" name="LotteryPrize[probability][]">' +
                            '<span class="help-inline col-xs-7 col-sm-7">' +
                                '<span class="middle"><p class="help-block help-block-error"></p></span>' +
                            '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';

        $("#home2prizes").append(html);
        prize++;
    }
</script>