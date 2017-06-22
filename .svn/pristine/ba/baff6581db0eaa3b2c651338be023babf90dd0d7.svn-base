<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $form ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'template' => '<div class="col-sm-3 align-right"> {label} </div>
					<div class="col-sm-4">{input}{hint}{error}</div>',
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'className')->textInput() ?>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn blue" type="submit">
                <i class="ace-icon fa fa-check bigger-110"></i>
                提交
            </button>
            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                重置
            </button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
