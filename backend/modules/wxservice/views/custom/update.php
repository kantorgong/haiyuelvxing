<?php
/**
 * update
 * 作者: limj
 * 版本: 17-4-19
 */


use yii\helpers\Html;
use yii\helpers\url;
/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = '修改公众号: ' . ' ' . $model->nick_name;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>