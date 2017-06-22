<?php

use yii\helpers\Html;
use yii\helpers\url;
/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = '修改访问统计: ' . ' ' . $model->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
