<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */

$this->title = Yii::t('rbac-admin', 'Update Menu') . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('rbac-admin', 'Update');
?>
<div class="page-header">
    <div class="pull-right tableTools-container">

        <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
            ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
    </div>
    <h3 class="page-title">
        <?= Html::encode($this->title) ?>
    </h3>
</div>

<?=
$this->render('_form', [
    'model' => $model,
]);
?>


