<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\components\RouteRule;
use mdm\admin\AutocompleteAsset;
use yii\helpers\Json;


/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$rules = Yii::$app->getAuthManager()->getRules();
unset($rules[RouteRule::RULE_NAME]);
$source = Json::htmlEncode(array_keys($rules));

$js = <<<JS
    $('#rule_name').autocomplete({
        source: $source,
    });
JS;
AutocompleteAsset::register($this);
$this->registerJs($js);
?>



    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'template' => '<div class="col-sm-3 align-right"> {label} </div>
					<div class="col-sm-2">{input}{hint}{error}</div>',
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 64, 'class' => 'form-control']) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 2, 'class' => 'form-control']) ?>

        <?= $form->field($model, 'ruleName')->textInput(['id' => 'rule_name', 'class' => 'form-control']) ?>

<!--        --><?//= $form->field($model, 'data')->textarea(['rows' => 4, 'class' => 'form-control']) ?>

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