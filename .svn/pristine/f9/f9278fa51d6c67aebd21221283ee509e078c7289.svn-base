<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="user-form">
    <div class="page-header">
        <div class="pull-right tableTools-container">

            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
        </div>
        <h3 class="page-title">
            <?= Html::encode($this->title) ?>
        </h3>
    </div>
    <?php $form = ActiveForm::begin([
			'options' => [
				'class' => 'form-horizontal',
			],
            'validateOnBlur' => false,
			'enableAjaxValidation' => true,
            'validateOnChange'  => false,
			'fieldConfig' => [
				'template' => '<div class="col-sm-3 align-right"> {label} </div>
					<div class="col-sm-4">{input}{hint}{error}</div>',
			],
		]); ?>

	<?= $form->field($model, 'username')->textInput(['class' => 'form-control']) ?>

	<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>

	<?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>

	<?= $form->field($model, 'name')->textInput(['class' => 'form-control']) ?>

	<?= $form->field($model, 'status')->dropDownList([0=>'激活',1=>'禁用'], ['class' => 'form-control']) ?>
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
