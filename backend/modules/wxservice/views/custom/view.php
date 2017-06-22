<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;
$this->title = '公众号';
?>
<div class="main-content-inner" style="width:99%">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="portlet-title">
            <div class="pull-right tableTools-container">
                <button type="button" class="btn btn-default" onclick="window.location.href='<?=Url::to(['index'])?>'">
                    <i class="ace-icon fa fa-reply icon-only"></i>返回
                </button>
            </div>
        </div>
        <div class="portlet-body">
            <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'pid',
                        ],
                        'app_name',
                        'alias_name',
                        'app_id',
                        [
                            'attribute' => 'app_type',
                            'value' => function ($data)
                                {
                                    $wxsAppTypeList = \components\helper\CommonUtility::getDictsList('wxs_app_type', 0, true);
                                    return $wxsAppTypeList[$data['app_type']];
                                },
                        ],
                        [
                            'attribute' => 'belong_user_id',
                            'value' => function($model)
                                {
                                    return $model->belong_user_id ? $model->belongor->user_name : '';
                                }
                        ],
                        [
                            'attribute' => 'disabled',
                            'format' => 'raw',
                            'value' => function($model)
                                {
//                                    return $model->disabled ? '禁用': '启用';
                                    if ($model->disabled)
                                    {
                                        $css = 'default';
                                        $word = '禁用';
                                    }
                                    else
                                    {
                                        $css = 'success';
                                        $word = '启用';
                                    }
                                    return '<span class="label label-'.$css.'">' . $word . '</span>';
                                }
                        ],
                        [
                            'attribute' => 'insert_time',
                            'label' => '添加时间',
                            'value' => function ($data)
                                {
                                    return $data['insert_time'] && $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '-';
                                },
                        ],
                        [
                            'attribute' => 'insert_id',
                            'label' => '添加人',
                            'value' => function ($model)
                                {
                                    if (!$model->insert_id) return '-';
                                    return $model->insertor->name;
                                },
                            'format' => 'raw',
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'header' => '操作',
                            'options' => ['width' => '50px;'],
                            'template' => '{set}',
                            'buttons' => [
                                'set' => function ($url, $data, $model)
                                    {

                                        if($data['belong_user_id'])
                                        {
                                            if($data['belong_user_id'] == \Yii::$app->request->get('id'))
                                            {
/*                                                return Html::a('取消选择','#', [
                                                    'title' => Yii::t('yii', '取消选择'),
                                                    'class' => 'btn btn-outline btn-sm red',
                                                    'onclick' => 'gridViewConfirm("确定要取消“'.$data['app_name'].'”吗？", "' . Url::to(['ajax','pid'=>$data['pid'],'uid'=>\Yii::$app->request->get('id'),'type'=>2]) . '");'
                                                ]);*/
                                                return Html::input('checkbox', 'switch-info', 2, ['data-size'=>'small','checked'=>false, 'data-info'=>$data['app_name'], 'data-url'=>Url::to(['ajax','pid'=>$data['pid'],'uid'=>\Yii::$app->request->get('id')])]);
                                            }
                                            else
                                            {
                                                return Html::button('该公众号已被选',[
                                                    'title' => Yii::t('yii', '选择'),
                                                    'class' => 'btn btn-outline btn-sm #D0DDE5',

                                                ]);
                                            }
                                        }
                                        else
                                        {
/*                                            return Html::a('选择','#', [
                                                'title' => Yii::t('yii', '选择'),
                                                'class' => 'btn btn-outline btn-sm yellow',
                                                'onclick' => 'gridViewConfirm("确定要选择“'.$data['app_name'].'”吗？", "' . Url::to(['ajax','pid'=>$data['pid'],'uid'=>\Yii::$app->request->get('id'),'type'=>1]) . '");'
                                            ]);*/
                                                return Html::input('checkbox', 'switch-info', 1, ['data-size'=>'small','checked'=>true, 'data-info'=>$data['app_name'], 'data-url'=>Url::to(['ajax','pid'=>$data['pid'],'uid'=>\Yii::$app->request->get('id')])]);
                                        }

                                    },
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    $(function(){
        $('[name="switch-info"]').bootstrapSwitch({
            onText:"选择",
            offText:"取消",
            onColor:"success",
            offColor:"info",
            size:"small",
            onInit:function(event,state){

            },
            onSwitchChange:function(event,state){
                var dataUrl = $(this).attr('data-url');
                if(state == true){
                    dataUrl = dataUrl + '&type=2';

                }else{

                    dataUrl = dataUrl + '&type=1';
                }
                window.parent.dialogGridViewConfirm(dataUrl);
            }
        })
    })
</script>