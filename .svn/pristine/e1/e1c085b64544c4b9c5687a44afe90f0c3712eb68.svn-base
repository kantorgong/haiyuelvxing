<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use mdm\admin\AnimateAsset;
use yii\web\YiiAsset;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Assignment */
/* @var $fullnameField string */
echo Html::csrfMetaTags();
$userName = $model->{$usernameField};
if (!empty($fullnameField)) {
    $userName .= ' (' . ArrayHelper::getValue($model, $fullnameField) . ')';
}
$userName = Html::encode($userName);

$this->title = Yii::t('rbac-admin', 'Assignment') . ' : ' . $userName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $userName;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
        'items' => $model->getItems()
    ]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="assignment-index">
    <div class="page-header">
        <div class="pull-right tableTools-container">

            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['user/index']) . '"']) ?>
        </div>
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <input class="form-control search" data-target="avaliable"
                   placeholder="<?= Yii::t('rbac-admin', 'Search for avaliable') ?>">
            <select multiple size="20" class="form-control list" data-target="avaliable">
            </select>
        </div>
        <div class="col-sm-1">
            <br><br>
            <?= Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => (string)$model->id], [
                'class' => 'btn btn-success btn-assign',
                'data-target' => 'avaliable',
                'title' => Yii::t('rbac-admin', 'Assign')
            ]) ?><br><br>
            <?= Html::a('&lt;&lt;' . $animateIcon, ['revoke', 'id' => (string)$model->id], [
                'class' => 'btn btn-danger btn-assign',
                'data-target' => 'assigned',
                'title' => Yii::t('rbac-admin', 'Remove')
            ]) ?>
        </div>
        <div class="col-sm-5">
            <input class="form-control search" data-target="assigned"
                   placeholder="<?= Yii::t('rbac-admin', 'Search for assigned') ?>">
            <select multiple size="20" class="form-control list" data-target="assigned">
            </select>
        </div>
    </div>
</div>
