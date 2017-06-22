<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>"/>
    <title><?= Yii::$app->name;?>登录</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
     <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    <?php $this->head(); ?>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->context->layout = false;
?>
<?php //$this->beginPage() ?>
<?php //$this->beginBody() ?>
</head>

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
        <h2 style="color:#fff"><?= Yii::$app->name;?></h2>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php $form = ActiveForm::begin(['id' => 'login-form' ,
                                    'method' => 'post' ,
                                    'options' => ['class' => 'login-form']
        ]); ?>
        <h3 class="form-title font-green">登录</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> 请输入账号密码 </span>
        </div>
            <?= $form->field($model, 'username')->textInput(['placeholder' => '用户名'])->label('用户名', ['class' => 'control-label visible-ie8 visible-ie9'])->error() ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码'])->label('密码', ['class' => 'control-label visible-ie8 visible-ie9'])->error() ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(),
            [
                'captchaAction' => 'default/captcha',
                'imageOptions' => ['id' => 'verifyCode', 'title' => '换一个', 'alt' => '换一个', 'style' => 'cursor:pointer;', 'onclick' =>'document.getElementById("verifyCode").src="/admin/default/captcha.html?v="+Math.random()*10000000;'],
                'template' => '<div class="form-control-solid" style="overflow:hidden"><div style="float:left;margin-right:6px;">{input}</div><div style="float:left;margin-top:5px;">{image}</div></div>',
                'options' => ['class' => 'form-control', 'maxlength' => '6', 'placeholder' => '验证码'],
            ]
        )->label('验证码', ['class' => 'control-label visible-ie8 visible-ie9'])->error() ?>
        <div class="form-actions">
            <?= Html::submitButton('登录', ['class' => 'btn green uppercase']) ?>
            <a href="javascript:;" id="forget-password" class="forget-password">忘记密码?</a>
        </div>
    <?php ActiveForm::end(); ?>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <div class="forget-form">
        <h3 class="font-green">忘记密码 ?</h3>
        <p> 请联系管理员admin@cms.xxcb.cn </p>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn green btn-outline">返回</button>
        </div>
    </div>

    <!-- END FORGOT PASSWORD FORM -->
</div>
<div class="copyright"> <?= date('Y');?> © <?= Yii::$app->name;?> </div>
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
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/pages/js/login.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>
