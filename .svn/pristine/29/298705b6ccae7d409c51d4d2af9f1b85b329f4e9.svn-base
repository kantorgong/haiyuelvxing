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
 * @Description Expression text is undefined on line 12, column 19 in Templates/Scripting/EmptyPHP.php.
 * @filesource Expression filesource is undefined on line 13, column 18 in Templates/Scripting/EmptyPHP.php.
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$forms = json_decode($model->forms, true);
$ids = array();
if(!empty($forms))
    $ids = array_keys($forms);
?>

<!--左侧开始-->
<div class="col-xs-12">
    <div class="page-header">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"'])
            ?>
        </div>
        <h1>
        <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="form-horizontal">
        <?php $disabled = $model->isNewRecord ? null : 'disabled'; $form = ActiveForm::begin([]); ?>
        <div class="col-sm-11 widget-container-col ui-sortable" style="min-height: 172px;">
            <div class="widget-box transparent ui-sortable-handle" style="opacity: 1; z-index: 0;">
                <div class="widget-header">
                    <div class="widget-toolbar no-border">
                        <ul class="nav nav-tabs" id="myTab2">
                            <li class="active"><a data-toggle="tab" href="#home2" aria-expanded="true">报名信息</a></li>
                            <li class=""><a data-toggle="tab" href="#profile2" aria-expanded="false">报名表单</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="widget-body">
                    <div class="widget-main padding-12 no-padding-left no-padding-right">
                        <div class="tab-content padding-4">
                            <div id="home2" class="tab-pane active">
                                <!-- #section:custom/scrollbar.horizontal -->
                                <div class="scrollable-horizontal ace-scroll">
                                    <div class="scroll-track scroll-hz scroll-top" style="display: none;">
                                        <div class="scroll-bar"></div>
                                    </div>
                                     <div class="scroll-content">
                                         <?=$form->field($model, 'mp_type', [
                                                         'template' => '{label}
                                                                <div class="col-sm-3">
                                                                    {input}
                                                                    {hint}{error}
                                                                </div>',
                                                         'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                                 ]
                                         )->dropDownList(
                                                 \common\models\wxservice\WxApps::appList(), ['prompt' => '请选择', 'class' => 'form-control']
                                         )
                                         ?>
                                         <?=$form->field($model, 'title', [
                                                         'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                                         'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                                 ]
                                         )->textInput(['maxlength' => true, 'class' => 'form-control'])
                                         ?>
                                         <?=$form->field($model, 'summary', [
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
                                         <?= $form->field($model, 'is_use', [
                                                 'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label>
                                                        <div class="col-sm-9"><small class="muted"></small>
                                                        <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                        </div>',
                                                 'labelOptions' => ['class' => ''],
                                         ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'mt-checkbox', 'type' => 'checkbox'], $enclosedByLabel = FALSE)
                                         ?>
                                    </div>
                                </div>
                            </div>

                            <div id="profile2" class="tab-pane">
                                <div class="scrollable ace-scroll" data-size="100" data-position="left"
                                     style="position: relative;">
                                     <div class="scroll-content">
                                         <?php foreach ($options as $row): ?>
                                        <div class="form-group">
	                                        <div class="col-sm-3 control-label">
		                                        <small class="muted"></small>
		                                        <label class="mt-checkbox mt-checkbox-outline">
<!--			                                        <input type="hidden" name="Apply[forms][]" value="--><?//=$row['id']?><!--">-->
			                                        <input type="checkbox" class="mt-checkbox" name="Apply[forms][]" value="<?=$row['id']?>" <?php if(in_array($row['id'], $ids)) echo 'checked="true"';?>>
			                                        <span></span>
		                                        </label>
	                                        </div>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" readonly value="<?= $row['info_title']?>" />
                                                <span class="help-inline col-xs-12 col-sm-7">
                                                    <span class="middle"><p class="help-block help-block-error"><?php if(!empty($row['options']))echo $row['options']; ?></p></span>
                                                </span>
                                            </div>
                                        </div>
                                         <?php endforeach;?>
                                    </div>
                                </div>
                                <div class="clearfix form-actions" style="clear: both">
                                    <div class="col-md-offset-3 col-md-9">
                                        <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' :
                                            '<i class="ace-icon fa fa-pencil bigger-110"></i>修改',
                                            ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-success']) ?>
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

<script>
    <?php
    ob_start();
    ?>

    parent.toastr.options = {
        closeButton: true,
        positionClass: 'toast-top-center'
    };

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