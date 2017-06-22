<?php
use yii\helpers\Url;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="page-header">
    <div class="pull-right tableTools-container">

        <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
            ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['/admin/dictcategory/index']) . '"']) ?>
    </div>
    <h3 class="page-title">
        <?= Html::encode($this->title) ?>
    </h3>
</div>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'form-horizontal',
    ],
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'template' => '<div class="col-sm-3 align-right"> {label} </div>
					<div class="col-sm-2">{input}{hint}{error}</div>',
    ],
]); ?>




<div class="form-group dict-parent_id required">
    <div class="col-sm-3 align-right"><label class="control-label" for="dict-parent_id">分类</label></div>
    <div class="col-sm-2"><input type="text" readonly="readonly" id="dict-parent_id" class="form-control"
                                 name="dict-parent_id"
                                 value="<?php echo $category['name'], '(', $category['id'], ')' ?>" maxlength="64">

<!--        <div class="help-inline" style="float: left; margin: 5px">格式参考：cms_np_num</div>-->
        <div class="help-block"></div>
    </div>
</div>


<div class="form-group field-dict-parent_id required">
    <div class="col-sm-3 align-right"><label class="control-label" for="field-dict-parent_id">父级名称</label></div>
    <div class="col-sm-2"><input type="text" id="field-dict-parent_id" readonly="readonly"
                                 name="field-dict-parent_id" value="<?php echo $parent->name ?>" class="form-control"
                                 maxlength="64">

<!--        <div class="help-inline" style="float: left; margin: 5px">格式参考：cms_np_num</div>-->
        <div class="help-block"></div>
    </div>
</div>



<?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>



<?= $form->field($model, 'value')->textInput(['maxlength' => 64]) ?>



<?= $form->field($model, 'sort_num')->textInput(['maxlength' => 64]) ?>





<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">
        <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' :
            '<i class="ace-icon fa fa-pencil bigger-110"></i>修改',
            ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>



