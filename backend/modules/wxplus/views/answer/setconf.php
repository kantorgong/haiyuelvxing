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
        <div class="portlet-body">
            <form action="" method="POST">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group field-scratchcardrank-open_id required">
                            <label class="col-sm-3 control-label" for="scratchcardrank-open_id">访问丢弃率</label>
                            <div class="col-sm-3">
                                <input type="text" id="scratchcardrank-open_id" class="form-control" name="isOpenRand" maxlength="64" value="<?= $isOpenRand ?>">
                                <div class="help-block">请设置一个整数值 0-100;值越大丢弃概率越大</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-sm-6">
                                <?= Html::submitButton('<i class="fa fa-check bigger-110"></i> 修改'
                                    ,
                                    ['class' => 'btn blue']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>