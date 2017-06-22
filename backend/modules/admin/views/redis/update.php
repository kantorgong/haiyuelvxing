<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="main-content-inner" style="width:99%">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="page-header">
            <div class="pull-right tableTools-container">
                <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                    ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
            </div>
            <h3 class="page-title">修改 "<?= \Yii::$app->request->get('key')?>" 的值</h3>
        </div>
        <div class="portlet-body">
            <div class="form-horizontal">
                <form id="activegroup-form" action="" method="post">
                    <input type="hidden" name="_csrf" value="LjRXRWR3cnFZQg4PXAAqO0xEGj8WEwYrSwJiBFYQNzJhfjo0FEVFAw==">
                    <div class="form-body">
                        <div class="form-group field-customextend-name required">
                            <label class="col-sm-3 control-label" for="customextend-name">键名称：</label>
                            <div class="col-sm-3">
                                <input type="text" id="customextend-name" class="form-control" name="key" value="<?= Html::encode(\Yii::$app->request->get('key'))?>" readonly>
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <div class="form-group field-customextend-status required">
                            <label class="col-sm-3 control-label" for="customextend-status">值:</label>
                            <div class="col-sm-3">
                                  <input type="text" id="customextend-name" class="form-control" name="value" value="<?= Html::encode(\Yii::$app->redis->get(\Yii::$app->request->get('key')))?>">
                                  <div class="help-block"></div>
                            </div>
                        </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-sm-6">
                            <button type="submit" class="btn blue"><i class="fa fa-check bigger-110"></i> 修改</button>                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
 