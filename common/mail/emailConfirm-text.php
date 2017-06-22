<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['member/member/reset-password', 'token' => $user->password_reset_token]);
$lifeSpan = (\Yii::$app->params['user.passwordResetTokenExpire']/3600);
?>
Hello <?= $user->username ?>,

点击以下链接激活账号，有效期<?= $lifeSpan?>小时：

<?= $resetLink ?>
