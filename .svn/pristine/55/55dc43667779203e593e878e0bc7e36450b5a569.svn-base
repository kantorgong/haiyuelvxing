<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\widgets\Pjax;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\BizRule */

$this->title = Yii::t('rbac-admin', 'Rule');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portlet">

    <div class="portlet-title">
        <div class="caption">
            <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn blue']) ?>
        </div>
    </div>

    <div class="portlet-body">
        <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'label' => Yii::t('rbac-admin', 'ID'),
            ],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac-admin', 'Name'),
            ],
            ['class' => 'backend\components\grid\ActionColumn',],
        ],
    ]);
    ?>
        </div>
</div>
</div>
