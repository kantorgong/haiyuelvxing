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
use components\helper\CommonUtility;
//$this->registerJsFile(Yii::getAlias('@web') . '/theme/ace/assets/js/jquery.gritter.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<!--左侧开始-->
<div class="col-xs-12">
    <div class="page-header">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', 
                    ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"'])
            ?>
        </div>
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="form-horizontal">
        <?php $disabled = $model->isNewRecord ? null : 'disabled';
        $form = ActiveForm::begin();
        ?>

        <div class="col-sm-11 widget-container-col ui-sortable" style="min-height: 172px;">
            <div class="widget-box transparent ui-sortable-handle" style="opacity: 1; z-index: 0;">
                <div class="widget-body">
                    <div class="widget-main padding-12 no-padding-left no-padding-right">
                        <div class="tab-content padding-4">
                            <div id="home2" class="tab-pane active">
                                <div class="scrollable-horizontal ace-scroll">
                                    <div class="scroll-track scroll-hz scroll-top" style="display: none;"><div class="scroll-bar"></div></div>
                                    <div class="scroll-content">
                                        <?=$form->field($model, 'info_title', [
                                                        'template' => '{label}
                                            <div class="col-sm-5">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                                        'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                                ]
                                        )->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => '中英文'])
                                        ?>
                                        <?=$form->field($model, 'info_name', [
                                                        'template' => '{label}
                                            <div class="col-sm-5">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                                        'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                                ]
                                        )->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => '仅限英文'])
                                        ?>
                                        <?= $form->field($model, 'info_label', [
                                                'template' => '{label}
                                            <div class="col-sm-5">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                                'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                            ]
                                        )->dropDownList(
                                                    ['input' => '文本框', 'select' => '下拉框', 'textarea' => '文本域'],
                                                    ['prompt' => '请选择', 'id' => 'info_label','class' => 'form-control','onchange'=>'
                                                    $.post("types.html?label="+$(this).val(),function(data){
                                                        $("#info_type").html(data);
                                                    });']
                                        )
                                        ?>
                                            <?= $form->field($model, 'info_type', [
                                                    'template' => '{label}
                                                <div class="col-sm-5">
                                                    {input}
                                                    {hint}{error}                                                           
                                                </div>',
                                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                                ]
                                            )->dropDownList(['text' => '文本', 'checkbox' => '复选', 'radio' => '单选', 'date' => '日期'], ['prompt' => '请选择','class' => 'form-control', 'id' => 'info_type'])
                                            ?>
                                        <?= $form->field($model, 'options', [
                                            'template' => '{label}
                                                    <div class="col-sm-5">
                                                        {input}
                                                        {hint}{error}
                                                    </div>',
                                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                                ]
                                        )->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => "html标签type属性是复选和单选时不能为空,用英文“,”间隔", 'id' => 'options',])
                                        ?>
                                        <?php if(!$disabled)$model->is_use = 1; echo $form->field($model, 'is_use', [
                                            'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label>
                                                    <div class="col-sm-9"><small class="muted"></small>
                                                    <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                    </div>',
                                            'labelOptions' => ['class' => ''],
                                        ])->checkbox(['checked' => '1','value' => 1, 'class' => 'mt-checkbox','type' => 'checkbox'], $enclosedByLabel = FALSE)
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix form-actions" style="clear: both">
         <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' :
                '<i class="ace-icon fa fa-pencil bigger-110"></i>修改',
                ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-success', 'onclick' => "return checktype();"]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    function checktype()
    {
        var label = $("#info_label").val();
        var type = $("#info_type").val();
        var options = $("#options").val();
        if(('checkbox' == type || 'radio' == type || 'select' == label) && !options)
        {
            window.parent.gritterAlert("警告", "选项不能为空", "gritter-warning");
            return false;
        }
        return true;
    }
</script>