<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="col-xs-11">
    <div class="page-header">
        <div class="pull-right tableTools-container">

            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                ['class' => 'btn btn-default', 'onclick' => 'window.location.href="'.Url::to(['index']).'"']) ?>
        </div>
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>



<div class="form-horizontal">
    <?php
    $disabled = $model->isNewRecord ? null : 'disabled';
    $form = ActiveForm::begin([
        'id' => 'user-form',
    ]);
    ?>


    <div class="form-group">
        <?php if ($model->scenario == 'update'): ?>

            <?= $form->field($model, 'name', [
                    'template' => '{label}
                                    <div class="col-sm-9">
                                        {input}
                                        <span class="help-inline col-xs-12 col-sm-7">
                                                    <span class="middle">{hint}{error}</span>
                                                </span>
                                    </div>',
                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                ]
            )->textInput([
                'maxlength' => true,
                'class' =>'col-xs-2 col-sm-2',
                'readonly' => 'readonly'
            ])

            ?>

        <? else :?>

            <?= $form->field($model, 'name', [
                    'template' => '{label}
                                <div class="col-sm-9">
                                    {input}
                                    <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle">{hint}{error}</span>
											</span>
                                </div>',
                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                ]
            )->textInput([
                'maxlength' => true,
                'class' =>'col-xs-2 col-sm-2',
            ])
            ?>
        <?php endif; ?>
    </div>




    <div class="form-group">
        <?= $form->field($model, 'description', [
                'template' => '{label}
                                <div class="col-sm-9">
                                    {input}
                                    <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle">{hint}{error}</span>
											</span>
                                </div>',
                'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
            ]
        )->textarea([
            'rows' => 6,
            'class' =>'col-xs-2 col-sm-2',
        ])

        ?>
    </div>




    <div class="form-group">
        <?= $form->field($model, 'disabled',[
            'template' => '<label class="col-sm-3 control-label no-padding-right muted" style="padding-top: 0px">{label}</label> <div class="col-sm-9"><small class="muted"></small>
                                {input}
                                <span class="lbl middle"></span></div>',
            'labelOptions' => ['class' => ''],
        ])->checkbox([
            'id' => 'gritter-light',
            'checked' => '1',
            'value' => 1,
            'class' => 'ace ace-switch ace-switch-5',
            'type' => 'checkbox',

        ],$enclosedByLabel= false)

        ?>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' :
                '<i class="ace-icon fa fa-pencil bigger-110"></i>修改',
                ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>
        </div>
    </div>

</div>

