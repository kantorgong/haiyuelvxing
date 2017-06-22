<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

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
            <h3 class="page-title">【<?=$title?>】领奖二维码</h3>
        </div>
        <div class="portlet-body">
            <div class="form-horizontal">
                <form action="" method="post">
                <div class="form-body">
                    <div class="alert alert-danger" v-if="!pwd">你还未设置领奖密码，请先设置领奖密码</div>
                    <div class="form-group" id="show-input-pwd" v-if="!pwd">
                        <label class="col-sm-3 control-label">领奖密码</label>
                        <div class="col-sm-3">
                            <input type="password" placeholder="请设置四位领奖密码" class="form-control" name="pwd" maxlength="4" minlength="4" v-model="pass">
                            <label class="label label-default">请设置四位领奖密码</label>
                        </div>
                    </div>
                    <div class="form-group" v-if="!pwd" id="show-input-repwd">
                        <label class="col-sm-3 control-label">确认领奖密码</label>
                        <div class="col-sm-3">
                            <input type="password" placeholder="确认领奖密码" class="form-control" name="repwd" maxlength="4" minlength="4" v-model="repass">
                        </div>
                    </div>
                    <div class="form-group" v-if="pwd" id="show-pwd">
                        <label class="col-sm-3 control-label">领奖密码</label>
                        <div class="col-sm-3">
                            <input type="password" v-model="pwd" class="form-control" id="pwd">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-danger" type="button" onclick="$('#pwd').attr('type', 'text')">显示密码</button>
                        </div>
                    </div>
                    <div class="form-group" v-if="pwd" id="show-qrcode">
                        <label class="col-sm-3 control-label">领奖二维码</label>
                        <div class="col-sm-3">
                            <img src="<?=Url::to(['qrcode', 'guid' => $guid])?>">
                        </div>
                    </div>
                </div>
                <div class="form-actions" v-if="!pwd" id="show-btn">
                    <div class="row">
                        <div class="col-md-offset-3 col-sm-6">
                            <button type="button" class="btn blue" @click="setPwd"><i class="fa fa-check bigger-110"></i> 确认</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    <?php
    ob_start();
    ?>

    new Vue({
	    'el': '.main-content-inner',
	    data: {
	        pwd: '<?=$pwd?>',
		    pass: '',
		    repass: ''
	    },
	    methods: {
	        setPwd: function() {
	            var _this = this;
	            if (!this.pass) {
                    parent.xcms_notific('错误', '领奖密码不能为空！', 'error');
                    return false;
	            }
	            if (this.pass.length !== 4) {
                    parent.xcms_notific('错误', '领奖密码必须为4位！', 'error');
                    return false;
	            }
	            if (this.pass !== this.repass) {
                    parent.xcms_notific('错误', '两次输入的密码不一致！', 'error');
                    return false;
	            }
                $.post('<?=Url::to(['get-prize', 'id' => Yii::$app->request->get('id')])?>',
	                {
	                    pwd: _this.pass
	                },
	                function(data) {
                        if (parseInt(data.status) === 0) {
                            parent.xcms_notific('成功', '密码设置成功！', 'success');
                            _this.pwd = _this.pass;
                        } else {
                            parent.xcms_notific('错误', '密码设置失败，请重试！', 'error');
                            return false;
                        }
	                },
	                'json');
	        }
	    }
    });

    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>


