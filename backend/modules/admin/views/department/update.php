<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\Department */

$this->title = '更新部门: ' . ' ' . $model->id;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


