<?php
/**
 * 后台管理通用模板
 * User: kantorgong
 * Date: 2015/9/11
 * Time: 11:08
 */

use backend\modules\admin\views\AdminAsset;


AdminAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>信息管理平台</title>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-notific8/jquery.notific8.min.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!--        <link href="--><?//= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />-->
    <!--        <link href="--><?//= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />-->
    <!--        <link href="--><?//= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />-->
    <!--        <link href="--><?//= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />-->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/apps/css/common.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />


    <?php $this->head(); ?>

</head>

<body>


<div class="main-container" id="main-container">
    <?php $this->beginBody(); ?>
    <?= $content ?>
    <?php $this->endBody(); ?>
</div>

<!--[if lt IE 9]>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/respond.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<!--<script src="--><?//= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-notific8/jquery.notific8.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/pages/scripts/ui-notific8.min.js" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/common/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/common/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/common/js/vue.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>

<script language="javascript">

    /* 弹出提示框配置 */
    toastr.options = {
        closeButton: true,
        positionClass: 'toast-top-center'
    };

    /*
     弹出框，删除、审核操作弹出框
     @msg为提示信息
     @url为ajax请求执行链接
     */
    function gridViewConfirm(msg, url) {
        //赋予msg
        $("#xcmsConfirmMsg").text(msg);
        $("#xcmsConfirmUrl").val(url);
        var xcmsmask = $('#xcmsmask').clone();
        var fatherBody = $(window.top.document.body);
        var dialog = $('#xcmsConfirm').clone();
        //复制模态窗到父窗口
        fatherBody.append(dialog);
        //复制遮罩到父窗口
        fatherBody.append(xcmsmask);
        fatherBody.find('#xcmsmask').show();

        //模态窗打开 关闭
        fatherBody.find("#xcmsConfirm").modal({
            backdrop: false,
            modal: true
        }).on('hidden.bs.modal', function (e) {
            fatherBody.find("#xcmsmask").remove();
            fatherBody.find('#xcmsConfirm').remove();
        });
        fatherBody.find('#ConfirmOk').on('click', function (e) {
            var fatherBody = $(window.top.document.body);
            //关闭模态窗
            fatherBody.find('#xcmsConfirm').modal('hide');

            //获取url 并在父窗口执行url
            var url = fatherBody.find("#xcmsConfirmUrl").attr("value");
            window.parent.dialogGridViewConfirm(url);

            //删除模态窗节点
            fatherBody.find('#xcmsConfirm').remove();
            fatherBody.find('#xcmsmask').remove();
        });
    }


    //模态窗 关闭
    $(function () {
        //关闭模态窗事件
        // $('#xcmsConfirm').on('hidden.bs.modal', function (e) {
        //     var fatherBody = $(window.top.document.body);
        //     fatherBody.find("#xcmsmask").hide();
        // });

        // //确认执行
        // $('#ConfirmOk').on('click', function (e) {
        //     var fatherBody = $(window.top.document.body);
        //     //关闭模态窗
        //     fatherBody.find('#xcmsConfirm').modal('hide');

        //     //获取url 并在父窗口执行url
        //     var url = fatherBody.find("#xcmsConfirmUrl").attr("value");
        //     window.parent.dialogGridViewConfirm(url);

        //     //删除模态窗节点
        //     fatherBody.find('#xcmsConfirm').remove();
        //     fatherBody.find('#xcmsmask').remove();
        // });
    });

</script>


<!--模态窗-->
<div class="modal fade" id="xcmsConfirm" tabindex="-1" role="xcmsConfirm" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">提醒</h4>
            </div>
            <div id="xcmsConfirmMsg" class="modal-body"> 确定要继续操作吗？ </div>
            <input type="hidden" id="xcmsConfirmUrl" />
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">关闭</button>
                <button id="ConfirmOk" type="button" class="btn green">确定</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--遮罩层-->
<div id="xcmsmask" class="modal-backdrop fade in" style="display: none"></div>

</body>
</html>
<?php $this->endPage(); ?>
