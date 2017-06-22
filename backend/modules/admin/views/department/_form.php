<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


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
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <div class="form-group field-menu-parentid">
                <label class="col-sm-3 control-label no-padding-right" for="menu-parentid">上级菜单</label>

                <div class="col-sm-9">
                    <select name="Department[parentid]" class="col-xs-4 col-sm-4" id="Department-parentid">
                        <?php echo backend\modules\admin\models\Department::getSelectTree('顶级菜单', $model->parentid, ($model->isNewRecord ? 0 : $model->id)); ?>
                    </select>
                      <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle"><div class="help-block"></div></span>
											</span>
                </div>
            </div>
        </div>


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
                    'class' => 'col-xs-2 col-sm-2',
                    'readonly' => 'readonly'
                ])

                ?>

            <?php else : ?>

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
            <?php endif; ?>
        </div>


        <div class="form-group">
            <?= $form->field($model, 'display', [
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


        <div class="form-group">
            <?= $form->field($model, 'description', [
                    'template' => '{label}
                                <div class="col-sm-6">
                                    {input}
                                    <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle">{hint}{error}</span>
											</span>
                                </div>',
                    'labelOptions' => ['class' => 'col-sm-3 control-label no-padding-right'],
                ]
            )->textarea([
                'maxlength' => 100,
                'rows' => 3,
            ])
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


