<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\admin\models\Role;
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
            'id' => 'user-form',
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

            <?php else: ?>

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
                <?= $form->field($model, 'password', [
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
                )->passwordInput([
                    'maxlength' => true,
                    'class' => 'col-xs-2 col-sm-2',
                    'value' => ''
                ])
                ?>

            <?php else: ?>
                <?= $form->field($model, 'password', [
                        'template' => '{label}
                                <div class="col-sm-9">
                                    {input}
                                    <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle">{hint}{error}</span>
											</span>
                                </div>',
                        'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                    ]
                )->passwordInput([
                    'maxlength' => true,
                    'class' => 'col-xs-2 col-sm-2',
                ])
                ?>
            <?php endif; ?>


        </div>


        <div class="form-group">
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
                'class' => 'col-xs-2 col-sm-2',
            ])

            ?>
        </div>


        <div class="form-group">
            <div class="form-group field-dpt_id">
                <label class="col-sm-3 control-label no-padding-right" for="menu-parentid">部门</label>

                <div class="col-sm-9">
                    <select name="User[dpt_id]" class="col-xs-3 col-sm-3" id="User-dpt_id">
                        <?php echo backend\modules\admin\models\Department::getSelectTree('请选择', $model->dpt_id, 0); ?>
                    </select>
                      <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle"><div class="help-block"></div></span>
											</span>
                </div>
            </div>
        </div>


        <div class="form-group">
            <?=
            $form->field($model, 'role_id', [
                    'template' => '{label}
                                <div class="col-sm-9">
                                    {input}
                                    <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle">{hint}{error}</span>
											</span>
                                </div>',
                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                ]
            )->dropDownList(Role::listDate(), [
                    'prompt' => '请选择角色',
                    'class' => 'col-xs-3 col-sm-3',
                ]
            )
            ?>
        </div>


        <div class="form-group">

            <?= $form->field($model, 'status', [
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

            ], $enclosedByLabel = false)

            ?>
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