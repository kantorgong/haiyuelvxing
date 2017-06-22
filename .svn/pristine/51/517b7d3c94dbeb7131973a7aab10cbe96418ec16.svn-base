<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = '项目配置';
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

            <div id="w0" class="grid-view">
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                    <tr>
                        <th colspan="4" style="text-align: center;">人员名单</th>
                    </tr>
                    <tr>
                        <th><a href="#">open_id</a></th>
                        <th><a href="#">昵称</a></th>
                        <th><a href="#">头像</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($userInfo as $info):?>
                    <?php $value = json_decode($info, true);?>
                        <tr data-key="1">
                            <td><?= $value['id'];?></td>
                            <td><?= $value['nickname'];?></td>
                            <td><img src="<?= $value['avatar'];?>" style="width: 40px;height: 40px" /></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>

        <div class="portlet-body">
            <div class="form-horizontal">
                <?php
                $disabled = $model->isNewRecord ? null : 'disabled';
                $form = ActiveForm::begin([
                    'id' => 'activegroup-form'
                ]);
                ?>
                <div class="form-body">

                    <?=$form->field($model, 'open_id', [
                            'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                            'labelOptions' => ['class' => 'col-sm-3 control-label','label'=>'用户标示(open_id)'],
                        ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                        ])?>
                    <div class="form-group field-scratchcardrank-open_id required">
                        <label class="col-sm-3 control-label" for="scratchcardrank-open_id">扫码获取open_id</label>
                        <div class="col-sm-3">
                            <div class="help-block">
                                <img src="data:image/png;base64,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"/>
                            </div>
                        </div>
                    </div>
                    <?=$form->field($model, 'score', [
                            'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                            'labelOptions' => ['class' => 'col-sm-3 control-label','label'=>'分数'],
                        ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                        ])?>

                    <?=$form->field($model, 'mtime', [
                            'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        {hint}{error}
                                    </div>',
                            'labelOptions' => ['class' => 'col-sm-3 control-label','label'=>'时间(单位毫秒)'],
                        ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control'
                        ])?>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-sm-6">
                            <?= Html::submitButton('<i class="fa fa-check bigger-110"></i> 修改'
                                ,
                                ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>