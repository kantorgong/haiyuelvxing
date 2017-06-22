<?php
$session = yii::$app->session;
$this->title = '首页';
?>
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
    <!-- END THEME LAYOUT STYLES -->

    <?php $this->head(); ?>
</head>

<body>


<div class="main-container" id="main-container">

    <h3 class="page-title"> 系统首页
        <small>系统信息</small>
    </h3>
    <div class="portlet-body">
        <div class="note note-info">
            <h4 class="block"> <?= Yii::$app->user->identity->name != '' ? Yii::$app->user->identity->name : Yii::$app->user->identity->username ?>，欢迎您的登录！
            </h4>
            <p>本次登录时间：<?=date('Y-m-d H:i:s',Yii::$app->user->identity->lastlogin_at != '' ? Yii::$app->user->identity->lastlogin_at : Yii::$app->user->identity->lastlogin_at)?></p>
            <p>本次登录I P：<?=Yii::$app->user->identity->lastlogin_ip != '' ? Yii::$app->user->identity->lastlogin_ip : Yii::$app->user->identity->lastlogin_ip?></p>
        </div>
    </div>

    <?php $this->beginBody(); ?>
    <?= $content ?>
    <?php $this->endBody(); ?>
</div>

<!--[if lt IE 9]>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/respond.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->



</body>
</html>
<?php $this->endPage(); ?>
