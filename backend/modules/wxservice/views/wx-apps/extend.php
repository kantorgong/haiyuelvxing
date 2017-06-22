<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\helpers\Url;
use common\models\wxservice\CustomAppsExtend;
$this->title = '扩展应用';
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
                            'attribute' => 'kid',
                        ],
                        'name',
                        /*
                        [
                            'attribute' => 'status',
                            'value' => function ($data)
                                {
                                    $wxsAppTypeList = \components\helper\CommonUtility::getDictsList('wx_extend_status', 0, true);
                                    return $wxsAppTypeList[$data['status']];
                                },
                        ],*/
                        [
                            'attribute' => 'insert_time',
                            'label' => '添加时间',
                            'value' => function ($data)
                                {
                                    return $data['insert_time'] && $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '-';
                                },
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'header' => '操作',
                            'options' => ['width' => '50px;'],
                            'template' => '{set}',
                            'buttons' => [
                                'set' => function ($url, $data, $model)
                                    {
                                        $result = CustomAppsExtend::find()->where(['kid'=>$data['kid'], 'pid'=>\Yii::$app->request->get('id')])->one();
                                        if($result)
                                        {
         /*                                   return Html::a('取消选择','#', [
                                                'title' => Yii::t('yii', '取消选择'),
                                                'class' => 'switch-info',
                                                'onclick' => 'gridViewConfirm("确定要取消“'.$data['name'].'”吗？", "' . Url::to(['extend/ajax','kid'=>$data['kid'],'pid'=>\Yii::$app->request->get('id'),'type'=>2]) . '");'
                                            ]);*/
                                            return Html::input('checkbox', 'switch-info', 2, ['data-size'=>'small','checked'=>false, 'data-info'=>$data['name'], 'data-url'=>Url::to(['extend/ajax','kid'=>$data['kid'],'pid'=>\Yii::$app->request->get('id')])]);
//                                            return '<input name="switch-info" type="checkbox" data-size="small">';
                                        }
                                        else
                                        {
/*                                            return Html::a('选择','#', [
                                                'title' => Yii::t('yii', '选择'),
                                                'class' => 'switch-info',
                                                'onclick' => 'gridViewConfirm("确定要选择“'.$data['name'].'”吗？", "' . Url::to(['extend/ajax','kid'=>$data['kid'],'pid'=>\Yii::$app->request->get('id'),'type'=>1]) . '");'
                                            ]);*/
                                            return Html::input('checkbox', 'switch-info', 1, ['data-size'=>'small','checked'=>true, 'data-info'=>$data['name'], 'data-url'=>Url::to(['extend/ajax','kid'=>$data['kid'],'pid'=>\Yii::$app->request->get('id')])]);
                                            //return '<input name="switch-info" type="checkbox" data-size="small">';
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
                var dataInfo = $(this).attr('data-info');
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