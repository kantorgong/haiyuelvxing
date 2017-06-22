<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$wxsAppTypeList = \components\helper\CommonUtility::getDictsList('wxs_app_type', 0, true);

?>

<div class="main-content-inner" style="width:99%">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="page-header">
            <div class="pull-right tableTools-container">
                <button type="button" class="btn btn-default" onclick="window.location.href='<?=Url::to(['index'])?>'">
                    <i class="ace-icon fa fa-reply icon-only"></i>返回
                </button>
            </div>
            <h3 class="page-title"><?=$this->title?></h3>
        </div>
        <div class="portlet-body">
            <div class="form-horizontal">
                <?php
                $disabled = $model->isNewRecord ? null : 'disabled';
                $form = ActiveForm::begin([
                    'id' => 'activegroup-form'
                ]);
                ?>
                <div class="form-body">

                    <?= $form->field($model, 'app_type', [
                                    'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->dropDownList(
                            $wxsAppTypeList, ['prompt' => '请选择', 'class' => 'form-control']
                    )
                    ?>

                    <?=$form->field($model, 'app_name', [
                            'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                        ]
                    )->textInput([
                        'maxlength' => true,
                        'class' => 'form-control'
                    ])?>


                    <?=$form->field($model, 'alias_name', [
                            'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                        <span class="label label-default">请尽量使用拼音的首字母，例如潇湘晨报：xxcb</span>
                                    </div>',
                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                        ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                    ])?>

                    <?=$form->field($model, 'app_id', [
                                    'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                    ])?>

                    <?=$form->field($model, 'app_key', [
                                    'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                    ])?>

                    <?=$form->field($model, 'app_token', [
                                    'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                    ])?>

                    <?=$form->field($model, 'payment_merchant_id', [
                                    'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                    ])?>

                    <?=$form->field($model, 'payment_key', [
                                    'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                    ])?>

                    <?=
                    $form->field($model, 'disabled', [
                            'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0">{label}</label>
                                                        <div class="col-sm-9"><small class="muted"></small>
                                                        <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                                        </div>',
                            'labelOptions' => ['class' => ''],
                    ])->checkbox(['checked' => '0', 'value' => 1, 'class' => 'mt-checkbox', 'type' => 'checkbox',], $enclosedByLabel = false)
                    ?>

                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-sm-6">
                            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check bigger-110"></i> 新增' :
                                '<i class="fa fa-pencil bigger-110"></i> 修改',
                                ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


