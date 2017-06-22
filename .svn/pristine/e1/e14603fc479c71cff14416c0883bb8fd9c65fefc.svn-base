<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$wxsExtendStatus = \components\helper\CommonUtility::getDictsList('wx_extend_status', 0, true);

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

                    <?=$form->field($model, 'name', [
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
                    <?= $form->field($model, 'status', [
                            'template' => '{label}
                                            <div class="col-sm-3">
                                                {input}
                                                {hint}{error}
                                            </div>',
                            'labelOptions' => ['class' => 'col-sm-3 control-label'],
                        ]
                    )->dropDownList(
                            $wxsExtendStatus, ['class' => 'form-control']
                        )
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