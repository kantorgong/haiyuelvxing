<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

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
                    'id' => 'rules-form'
                ]);
                ?>
                <div class="form-body">
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
                                                                    <div class="label label-default">每行一条数据，注释请用###分隔</div>
                                                                </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textarea(['maxlength' => true, 'class' => 'form-control', 'rows' => 5])
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


