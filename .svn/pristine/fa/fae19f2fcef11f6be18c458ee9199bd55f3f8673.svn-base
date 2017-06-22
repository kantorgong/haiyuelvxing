<?php

/**
 * @filename form.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-22 10:59:48
 * @version 1.0
 * @copyright (c) 2016-3-22, 潇湘晨报（版权）
 * @access public 权限
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use components\helper\CommonUtility;
$this->title = stripslashes($model->title) . "【表单】";
$model->forms = json_decode($model->forms);
?>
<script src="<?= Yii::getAlias('@web') ?>/theme/ace/assets/js/moment.js"></script>
<link href="<?= Yii::getAlias('@web') ?>/theme/ace/assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?= Yii::getAlias('@web') ?>/theme/ace/assets/js/bootstrap-datetimepicker.js"></script>
<div class="catalog-create">
	<div class="col-xs-12">
    <div class="page-header">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', 
                    ['class' => 'btn btn-white btn-success', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"'])
            ?>
        </div>
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="form-horizontal">
        <?php $disabled = $model->isNewRecord ? null : 'disabled'; $form = ActiveForm::begin(); ?>
        <div class="col-sm-11 widget-container-col ui-sortable" style="min-height: 172px;">
            <div class="widget-box transparent ui-sortable-handle" style="opacity: 1; z-index: 0;">
                <div class="widget-body">
                    <div class="widget-main padding-12 no-padding-left no-padding-right">
                        <div class="tab-content padding-4">
                            <div id="home2" class="tab-pane active">
                                <div class="scrollable-horizontal ace-scroll">
                                    <div class="scroll-track scroll-hz scroll-top" style="display: none;"><div class="scroll-bar"></div></div>
                                    <div class="scroll-content">
                                        <?php foreach($model->forms as $applyform):?>
                                        <div class="form-group">
                                            <div class="form-group field-apply-start_time required checkbox">
                                                <label class="col-sm-3 control-label no-padding-right" for="<?= $applyform->name?>"><?= $applyform->text?></label>
                                                <div class="col-sm-9">
                                                    <?php 
                                                    if("select" == $applyform->label)
                                                    {
                                                        $html = "<select class='col-xs-3 col-sm-3' name='{$applyform->name}'>";
                                                        foreach (explode(",", $applyform->options) as $op)
                                                        {
                                                            $html .= "<option value='{$op}'>{$op}</option>";
                                                        }
                                                        $html .= "</select>";
                                                    }
                                                    elseif("textarea" == $applyform->label)
                                                    {
                                                        $html = "<textarea class='col-xs-3 col-sm-3' name='{$applyform->name}'></textarea>";
                                                    }
                                                    elseif('input' == $applyform->label && 'text' == $applyform->type)
                                                    {
                                                        $html = "<input class='col-xs-5 col-sm-5' name='{$applyform->name}' type='text'/>";
                                                    }
                                                    elseif('input' == $applyform->label && 'date' == $applyform->type)
                                                    {
                                                        $html = "<input class='col-xs-3 col-sm-3 dateTime' name='{$applyform->name}' id='{$applyform->name}' type='text'/>";
                                                        $html .= "<script>
                                                                        var names = '{$applyform->name}';
                                                                        $('#'+names+'').datetimepicker().next().on(ace.click_event, function () {
                                                                            $(this).prev().focus();
                                                                        });
                                                                </script>";
                                                    }
                                                    elseif('input' == $applyform->label && 'radio' == $applyform->type)
                                                    {
                                                        $html = '';
                                                        foreach (explode(",", $applyform->options) as $op)
                                                        {
                                                            $html .= "<div class='radio'>
                                                                        <label>
                                                                            <input name='{$applyform->name}' type='radio' class='ace'>
                                                                            <span class='lbl'>{$op}</span>
                                                                        </label>
                                                                    </div>";
                                                        }
                                                    }
                                                    elseif('input' == $applyform->label && 'checkbox' == $applyform->type)
                                                    {
                                                        $html = '';
                                                        foreach (explode(",", $applyform->options) as $op)
                                                        {
                                                            $html .= "<div class='checkbox'>
                                                                        <label>
                                                                            <input name='{$applyform->name}' type='checkbox' class='ace'>
                                                                            <span class='lbl'>{$op}</span>
                                                                        </label>
                                                                    </div>";
                                                        }
                                                    }
                                                    echo $html;
                                                    ?>
                                                    <span class="help-inline col-xs-12 col-sm-7">
                                                        <span class="middle"><p class="help-block help-block-error"><?php if(!empty($row['options']))echo $row['options']; ?></p></span>
                                                    </span>
                                                </div>
                                            </div>                                        
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>