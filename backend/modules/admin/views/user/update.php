<?php

use yii\helpers\Html;
use yii\helpers\url;
/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = '修改用户: ' . ' ' . $model->name;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
