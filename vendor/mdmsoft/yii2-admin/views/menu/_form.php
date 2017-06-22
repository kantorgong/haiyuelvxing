<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\Menu;
use yii\helpers\Json;
use mdm\admin\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => Menu::getMenuSource(),
    'routes' => Menu::getSavedRoutes(),
]);

$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<div class="menu-form">
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
    <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>


    <?= $form->field($model, 'name')->textInput() ?>


    <?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name', 'class' => 'form-control']) ?>



    <?= $form->field($model, 'route')->textInput() ?>

    <?= $form->field($model, 'order')->input('number', ['class' => 'form-control']) ?>



    <div class="form-group">
        <div class="form-group field-user-role_id">
            <label class="col-sm-3 control-label" for="menu-icon">图标</label>

            <div class="col-sm-3">
                <?= Html::activeHiddenInput($model, 'icon') ?>
                <a id="longbtn" class="bg-light  text-center" style="width: 90px; display: block">
                    <i class="fa fa-<?= ($model->icon) ? $model->icon : 'desktop' ?> inline fa-light fa-3x m-t-large m-b-large"
                       id="menuIcon"></i>
                </a>
                <!-- <span class="help-inline col-xs-12 col-sm-7">
                     <span class="middle"><div class="help-block"></div></span>
                </span> -->
            </div>
        </div>
    </div>

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

<style>
    .fa-item {
        overflow: hidden;
        height: 35px;
    }
    #longbtn .fa{
        line-height:1;
    }
</style>


<script language="javascript">
    //模态窗弹出 关闭
    $(function () {
        var longbtn = $('#longbtn');
        longbtn.on('click', function () {
            var xcmsmask = $('#xcmsmask').clone();
            var fatherBody = $(window.top.document.body);
            var dialog = $('#long').clone();
            //复制模态窗到父窗口
            fatherBody.append(dialog);
            //复制遮罩到父窗口
            fatherBody.append(xcmsmask);
            //遮罩打开
            fatherBody.find('#xcmsmask').show();
            //模态窗打开
            fatherBody.find("#long").modal({
                backdrop: false,
                modal: true
            }).on('hidden.bs.modal', function (e) {
                fatherBody.find("#xcmsmask").remove();
                fatherBody.find('#long').remove();
            });
            //图标选择事件
            var longli = fatherBody.find('#long');
            longli.find('#menulist div').on('click', function () {
                icon = $.trim($(this).text());
                $('#menuIcon').attr('class', 'fa fa-' + icon + ' inline fa-light fa-3x m-t-large m-b-large');
                $('#menu-icon').val(icon);
                fatherBody.find("#long").modal('hide');

                fatherBody.find("#xcmsmask").remove();
                fatherBody.find('#long').remove();
            });
          });

        //关闭模态窗事件
        // $('#long').on('hidden.bs.modal', function (e) {
        //     fatherBody.find("#xcmsmask").hide();
        // });




    });

</script>

<!--弹出窗口-->
<div id="long" class="modal fade modal-scroll" tabindex="-1" data-replace="true">
    <div class="modal-dialog" style="width:800px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">请选择图标</h4>
            </div>
            <div class="modal-body" style="overflow: auto;height: 400px;">
                <div id="menulist" class="row fontawesome-icon-list">
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-caret-right"></i> caret-right
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-anchor"></i> anchor
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-archive"></i> archive
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-area-chart"></i> area-chart
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-arrows"></i> arrows
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-arrows-h"></i> arrows-h
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-arrows-v"></i> arrows-v
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-asterisk"></i> asterisk
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-at"></i> at
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-automobile"></i> automobile
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-balance-scale"></i> balance-scale
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-ban"></i> ban
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bank"></i> bank
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bar-chart"></i> bar-chart
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bar-chart-o"></i> bar-chart-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-barcode"></i> barcode
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bars"></i> bars
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-0"></i> battery-0
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-1"></i> battery-1
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-2"></i> battery-2
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-3"></i> battery-3
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-4"></i> battery-4
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-empty"></i> battery-empty
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-full"></i> battery-full
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-half"></i> battery-half
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-quarter"></i> battery-quarter
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-battery-three-quarters"></i> battery-three-quarters
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bed"></i> bed
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-beer"></i> beer
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bell"></i> bell
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bell-o"></i> bell-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bell-slash"></i> bell-slash
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bell-slash-o"></i> bell-slash-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bicycle"></i> bicycle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-binoculars"></i> binoculars
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-birthday-cake"></i> birthday-cake
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bolt"></i> bolt
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bomb"></i> bomb
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-book"></i> book
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bookmark"></i> bookmark
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bookmark-o"></i> bookmark-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-briefcase"></i> briefcase
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bug"></i> bug
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-building"></i> building
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-building-o"></i> building-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bullhorn"></i> bullhorn
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bullseye"></i> bullseye
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-bus"></i> bus
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cab"></i> cab
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-calculator"></i> calculator
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-calendar"></i> calendar
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-calendar-check-o"></i> calendar-check-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-calendar-minus-o"></i> calendar-minus-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-calendar-o"></i> calendar-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-calendar-plus-o"></i> calendar-plus-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-calendar-times-o"></i> calendar-times-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-camera"></i> camera
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-camera-retro"></i> camera-retro
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-car"></i> car
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-caret-square-o-down"></i> caret-square-o-down
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-caret-square-o-left"></i> caret-square-o-left
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-caret-square-o-right"></i> caret-square-o-right
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-caret-square-o-up"></i> caret-square-o-up
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cart-arrow-down"></i> cart-arrow-down
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cart-plus"></i> cart-plus
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cc"></i> cc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-certificate"></i> certificate
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-check"></i> check
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-check-circle"></i> check-circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-check-circle-o"></i> check-circle-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-check-square"></i> check-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-check-square-o"></i> check-square-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-child"></i> child
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-circle"></i> circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-circle-o"></i> circle-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-circle-o-notch"></i> circle-o-notch
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-circle-thin"></i> circle-thin
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-clock-o"></i> clock-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-clone"></i> clone
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-close"></i> close
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cloud"></i> cloud
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cloud-download"></i> cloud-download
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cloud-upload"></i> cloud-upload
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-code"></i> code
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-code-fork"></i> code-fork
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-coffee"></i> coffee
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cog"></i> cog
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cogs"></i> cogs
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-comment"></i> comment
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-comment-o"></i> comment-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-commenting"></i> commenting
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-commenting-o"></i> commenting-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-comments"></i> comments
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-comments-o"></i> comments-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-compass"></i> compass
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-copyright"></i> copyright
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-creative-commons"></i> creative-commons
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-credit-card"></i> credit-card
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-crop"></i> crop
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-crosshairs"></i> crosshairs
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cube"></i> cube
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cubes"></i> cubes
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-cutlery"></i> cutlery
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-dashboard"></i> dashboard
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-database"></i> database
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-desktop"></i> desktop
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-diamond"></i> diamond
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-dot-circle-o"></i> dot-circle-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-download"></i> download
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-edit"></i> edit
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-ellipsis-h"></i> ellipsis-h
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-ellipsis-v"></i> ellipsis-v
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-envelope"></i> envelope
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-envelope-o"></i> envelope-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-envelope-square"></i> envelope-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-eraser"></i> eraser
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-exchange"></i> exchange
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-exclamation"></i> exclamation
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-exclamation-circle"></i> exclamation-circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-exclamation-triangle"></i> exclamation-triangle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-external-link"></i> external-link
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-external-link-square"></i> external-link-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-eye"></i> eye
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-eye-slash"></i> eye-slash
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-eyedropper"></i> eyedropper
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-fax"></i> fax
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-feed"></i> feed
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-female"></i> female
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-fighter-jet"></i> fighter-jet
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-archive-o"></i> file-archive-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-audio-o"></i> file-audio-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-code-o"></i> file-code-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-excel-o"></i> file-excel-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-image-o"></i> file-image-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-movie-o"></i> file-movie-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-pdf-o"></i> file-pdf-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-photo-o"></i> file-photo-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-picture-o"></i> file-picture-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-powerpoint-o"></i> file-powerpoint-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-sound-o"></i> file-sound-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-video-o"></i> file-video-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-word-o"></i> file-word-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-file-zip-o"></i> file-zip-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-film"></i> film
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-filter"></i> filter
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-fire"></i> fire
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-fire-extinguisher"></i> fire-extinguisher
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-flag"></i> flag
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-flag-checkered"></i> flag-checkered
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-flag-o"></i> flag-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-flash"></i> flash
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-flask"></i> flask
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-folder"></i> folder
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-folder-o"></i> folder-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-folder-open"></i> folder-open
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-folder-open-o"></i> folder-open-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-frown-o"></i> frown-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-futbol-o"></i> futbol-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-gamepad"></i> gamepad
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-gavel"></i> gavel
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-gear"></i> gear
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-gears"></i> gears
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-gift"></i> gift
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-glass"></i> glass
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-globe"></i> globe
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-graduation-cap"></i> graduation-cap
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-group"></i> group
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-grab-o"></i> hand-grab-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-lizard-o"></i> hand-lizard-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-paper-o"></i> hand-paper-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-peace-o"></i> hand-peace-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-pointer-o"></i> hand-pointer-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-rock-o"></i> hand-rock-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-scissors-o"></i> hand-scissors-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-spock-o"></i> hand-spock-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hand-stop-o"></i> hand-stop-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hdd-o"></i> hdd-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-headphones"></i> headphones
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-heart"></i> heart
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-heart-o"></i> heart-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-heartbeat"></i> heartbeat
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-history"></i> history
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-home"></i> home
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hotel"></i> hotel
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass"></i> hourglass
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass-1"></i> hourglass-1
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass-2"></i> hourglass-2
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass-3"></i> hourglass-3
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass-end"></i> hourglass-end
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass-half"></i> hourglass-half
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass-o"></i> hourglass-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-hourglass-start"></i> hourglass-start
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-i-cursor"></i> i-cursor
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-image"></i> image
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-inbox"></i> inbox
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-industry"></i> industry
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-info"></i> info
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-info-circle"></i> info-circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-institution"></i> institution
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-key"></i> key
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-keyboard-o"></i> keyboard-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-language"></i> language
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-laptop"></i> laptop
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-leaf"></i> leaf
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-legal"></i> legal
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-lemon-o"></i> lemon-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-level-down"></i> level-down
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-level-up"></i> level-up
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-life-bouy"></i> life-bouy
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-life-buoy"></i> life-buoy
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-life-ring"></i> life-ring
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-life-saver"></i> life-saver
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-lightbulb-o"></i> lightbulb-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-line-chart"></i> line-chart
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-location-arrow"></i> location-arrow
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-lock"></i> lock
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-magic"></i> magic
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-magnet"></i> magnet
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-mail-forward"></i> mail-forward
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-mail-reply"></i> mail-reply
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-mail-reply-all"></i> mail-reply-all
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-male"></i> male
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-map"></i> map
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-map-marker"></i> map-marker
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-map-o"></i> map-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-map-pin"></i> map-pin
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-map-signs"></i> map-signs
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-meh-o"></i> meh-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-microphone"></i> microphone
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-microphone-slash"></i> microphone-slash
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-minus"></i> minus
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-minus-circle"></i> minus-circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-minus-square"></i> minus-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-minus-square-o"></i> minus-square-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-mobile"></i> mobile
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-mobile-phone"></i> mobile-phone
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-money"></i> money
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-moon-o"></i> moon-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-mortar-board"></i> mortar-board
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-motorcycle"></i> motorcycle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-mouse-pointer"></i> mouse-pointer
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-music"></i> music
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-navicon"></i> navicon
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-newspaper-o"></i> newspaper-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-object-group"></i> object-group
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-object-ungroup"></i> object-ungroup
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-paint-brush"></i> paint-brush
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-paper-plane"></i> paper-plane
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-paper-plane-o"></i> paper-plane-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-paw"></i> paw
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-pencil"></i> pencil
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-pencil-square"></i> pencil-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-pencil-square-o"></i> pencil-square-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-phone"></i> phone
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-phone-square"></i> phone-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-photo"></i> photo
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-picture-o"></i> picture-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-pie-chart"></i> pie-chart
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-plane"></i> plane
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-plug"></i> plug
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-plus"></i> plus
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-plus-circle"></i> plus-circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-plus-square"></i> plus-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-plus-square-o"></i> plus-square-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-power-off"></i> power-off
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-print"></i> print
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-puzzle-piece"></i> puzzle-piece
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-qrcode"></i> qrcode
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-question"></i> question
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-question-circle"></i> question-circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-quote-left"></i> quote-left
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-quote-right"></i> quote-right
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-random"></i> random
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-recycle"></i> recycle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-refresh"></i> refresh
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-registered"></i> registered
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-remove"></i> remove
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-reorder"></i> reorder
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-reply"></i> reply
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-reply-all"></i> reply-all
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-retweet"></i> retweet
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-road"></i> road
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-rocket"></i> rocket
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-rss"></i> rss
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-rss-square"></i> rss-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-search"></i> search
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-search-minus"></i> search-minus
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-search-plus"></i> search-plus
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-send"></i> send
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-send-o"></i> send-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-server"></i> server
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-share"></i> share
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-share-alt"></i> share-alt
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-share-alt-square"></i> share-alt-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-share-square"></i> share-square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-share-square-o"></i> share-square-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-shield"></i> shield
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-ship"></i> ship
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-shopping-cart"></i> shopping-cart
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sign-in"></i> sign-in
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sign-out"></i> sign-out
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-signal"></i> signal
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sitemap"></i> sitemap
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sliders"></i> sliders
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-smile-o"></i> smile-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-soccer-ball-o"></i> soccer-ball-o
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort"></i> sort
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-alpha-asc"></i> sort-alpha-asc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-alpha-desc"></i> sort-alpha-desc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-amount-asc"></i> sort-amount-asc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-amount-desc"></i> sort-amount-desc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-asc"></i> sort-asc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-desc"></i> sort-desc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-down"></i> sort-down
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-numeric-asc"></i> sort-numeric-asc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-numeric-desc"></i> sort-numeric-desc
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sort-up"></i> sort-up
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-space-shuttle"></i> space-shuttle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-spinner"></i> spinner
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-spoon"></i> spoon
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-square"></i> square
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-square-o"></i> square-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-star"></i> star
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-star-half"></i> star-half
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-star-half-empty"></i> star-half-empty
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-star-half-full"></i> star-half-full
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-star-half-o"></i> star-half-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-star-o"></i> star-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sticky-note"></i> sticky-note
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sticky-note-o"></i> sticky-note-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-street-view"></i> street-view
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-suitcase"></i> suitcase
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-sun-o"></i> sun-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-support"></i> support
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tablet"></i> tablet
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tachometer"></i> tachometer
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tag"></i> tag
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tags"></i> tags
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tasks"></i> tasks
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-taxi"></i> taxi
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-television"></i> television
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-terminal"></i> terminal
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-thumb-tack"></i> thumb-tack
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-thumbs-down"></i> thumbs-down
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-thumbs-o-down"></i> thumbs-o-down
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-thumbs-o-up"></i> thumbs-o-up
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-thumbs-up"></i> thumbs-up
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-ticket"></i> ticket
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-times"></i> times
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-times-circle"></i> times-circle
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-times-circle-o"></i> times-circle-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tint"></i> tint
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-toggle-down"></i> toggle-down
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-toggle-left"></i> toggle-left
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-toggle-off"></i> toggle-off
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-toggle-on"></i> toggle-on
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-toggle-right"></i> toggle-right
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-toggle-up"></i> toggle-up
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-trademark"></i> trademark
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-trash"></i> trash
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-trash-o"></i> trash-o
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tree"></i> tree
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-trophy"></i> trophy
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-truck"></i> truck
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tty"></i> tty
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-tv"></i> tv
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-umbrella"></i> umbrella
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-university"></i> university
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-unlock"></i> unlock
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-unlock-alt"></i> unlock-alt
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-unsorted"></i> unsorted
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-upload"></i> upload
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-user"></i> user
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-user-plus"></i> user-plus
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-user-secret"></i> user-secret
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-user-times"></i> user-times
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-users"></i> users
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-video-camera"></i> video-camera
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-volume-down"></i> volume-down
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-volume-off"></i> volume-off
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-volume-up"></i> volume-up
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-warning"></i> warning
                        <span class="text-muted">(alias)</span>
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-wheelchair"></i> wheelchair
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-wifi"></i> wifi
                    </div>
                    <div class="fa-item col-md-3 col-sm-4">
                        <i class="fa fa-wrench"></i> wrench
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
            </div>
        </div>
    </div>
</div>

<!--遮罩层-->
<div id="xcmsmask" class="modal-backdrop fade in" style="display: none"></div>
