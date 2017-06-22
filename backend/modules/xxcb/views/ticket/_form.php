<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use components\helper\CommonUtility;
?>
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
    //'enableAjaxValidation' => true,
    'fieldConfig' => [
        'template' => '<div class="col-sm-3 align-right"> {label} </div>
					<div class="col-sm-3">{input}{hint}{error}</div>',
    ],
]); ?>

<?= $form->field($model, 'title', [
    'parts' => ['{hint}' => '<div class="help-inline" style="float: left; margin: 5px">格式参考：cms_np_num</div>'],
])->textInput(['maxlength' => 255]) ?>


<?= $form->field($model, 'title', [
    'parts' => ['{hint}' => '<div class="help-inline" style="float: left; margin: 5px">格式参考：发布系统上传限制
</div>'],
])->textInput(['maxlength' => 64]) ?>


<?= $form->field($model, 'start_time', [
    'parts' => ['{hint}' => ''],
])->dropDownList(CommonUtility::getDataType(),[
            'prompt' => '请选择',
            'class' =>'form-control col-sm-3',
        ]
    )
?>


<?= $form->field($model, 'venue_id', [
    'template' => '<label class="col-sm-3 control-label muted" style="padding-top: 0px">{label}</label> <div class="col-sm-9"><small class="muted"></small>
                                <label class="mt-checkbox mt-checkbox-outline">{input}<span></span></label>
                                </div>',
    'labelOptions' => ['class' => ''],
])->checkbox([
        'id' => 'gritter-light',
        'checked' => '1',
        'value' => 1,
        'class' => 'mt-checkbox',
        'type' => 'checkbox',

    ], $enclosedByLabel = false) ?>

<?= $form->field($model, 'detail', [
    'parts' => ['{hint}' => ''],
])->textInput(['maxlength' => 64]) ?>

<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">
        <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' :
                '<i class="ace-icon fa fa-pencil bigger-110"></i>修改',
            ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>