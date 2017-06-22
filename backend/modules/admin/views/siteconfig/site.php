<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$this->title = '网站配置 ';
?>

<div class="col-xs-11">


    <div class="form-horizontal">
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal',
            ],
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'template' => '<div class="col-sm-3 align-right"> {label} </div>
					<div class="col-sm-3">{input}{hint}{error}</div>',
            ],
        ]); ?>


        <div class="col-sm-12 widget-container-col ui-sortable" style="min-height: 172px;">
            <div class="widget-box transparent ui-sortable-handle" style="opacity: 1; z-index: 0;">
                <div class="widget-header">

                    <div class="widget-toolbar no-border">
                        <ul class="nav nav-tabs" id="myTab2">
                            <li class="active">
                                <a data-toggle="tab" href="#home2" aria-expanded="true">基本配置</a>
                            </li>


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

                                        <?= $form->field($model, 'site_name')->textInput(['maxlength' => 30]) ?>


                                        <?= $form->field($model, 'site_url')->textInput(['maxlength' => 40]) ?>


                                        <?= $form->field($model, 'site_admin_email')->textInput(['maxlength' => 50]) ?>


                                        <?= $form->field($model, 'site_icp')->textInput(['maxlength' => 40]) ?>


                                        <?= $form->field($model, 'site_copyright')->textarea(['rows' => 3]) ?>

                                    </div>
                                </div>

                                <!-- /section:custom/scrollbar.horizontal -->
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
                    ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

