<?php

use yii\helpers\Html;
use yii\helpers\url;
/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = '更新全局规则';
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
