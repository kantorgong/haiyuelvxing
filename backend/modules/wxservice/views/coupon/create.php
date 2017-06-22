<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = '新增优惠券';

?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

