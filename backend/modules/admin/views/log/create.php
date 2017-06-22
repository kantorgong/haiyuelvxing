<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>


<div class="col-xs-11">
    <div class="page-header">
        <div class="pull-right tableTools-container">

            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
        </div>
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="form-horizontal">

        <?php
        $disabled = $model->isNewRecord ? null : 'disabled';
        $form = ActiveForm::begin([
            'id' => 'log-form',
        ]);
        ?>

        <div class="form-group">
            <?php if ($model->scenario == 'update'): ?>

                <?= $form->field($model, 'username', [
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
                    'class' => 'col-xs-2 col-sm-2',
                    'readonly' => 'readonly'
                ])

                ?>

            <? else : ?>

                <?= $form->field($model, 'username', [
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
                    'class' => 'col-xs-2 col-sm-2',
                ])
                ?>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <?php if ($model->scenario == 'update'): ?>
                <?= $form->field($model, 'url', [
                        'template' => '{label}
                                <div class="col-sm-9">
                                    {input}
                                    <span class="help-inline col-xs-12 col-sm-7">
												{hint}{error}
											</span>
                                </div>',
                        'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                        'parts' => ['{hint}' => '<div class="help-inline" style="float: left; margin: 5px">不修改请留空</div>'],
                    ]
                )->textInput([
                    'maxlength' => true,
                    'class' => 'col-xs-2 col-sm-2',
                    'value' => ''
                ])
                ?>

            <?php else: ?>
                <?= $form->field($model, 'url', [
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
                    'class' => 'col-xs-2 col-sm-2',
                ])
                ?>
            <?php endif; ?>




            <div class="form-group">
                <?php if ($model->scenario == 'update'): ?>
                    <?= $form->field($model, 'ip', [
                            'template' => '{label}
                                <div class="col-sm-9">
                                    {input}
                                    <span class="help-inline col-xs-12 col-sm-7">
												{hint}{error}
											</span>
                                </div>',
                            'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                            'parts' => ['{hint}' => '<div class="help-inline" style="float: left; margin: 5px">不修改请留空</div>'],
                        ]
                    )->textInput([
                        'maxlength' => true,
                        'class' => 'col-xs-2 col-sm-2',
                        'value' => ''
                    ])
                    ?>

                <?php else: ?>
                    <?= $form->field($model, 'ip', [
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
                        'class' => 'col-xs-2 col-sm-2',
                    ])
                    ?>
                <?php endif; ?>


            </div>


            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' :
                        '<i class="ace-icon fa fa-pencil bigger-110"></i>修改',
                        ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>
                </div>
            </div>




            <?php ActiveForm::end(); ?>

        </div>

    </div>