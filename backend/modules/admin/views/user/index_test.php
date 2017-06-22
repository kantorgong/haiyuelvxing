<?php

use yii\helpers\Html;
use backend\modules\admin\widget\MyGridView;
$this->title = '用户';
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建'.$this->title, ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            <!--            <button class="btn btn-success btn-sm" id="bootbox-regular">普通</button>-->
            <!--            <button class="btn btn-info  btn-sm" id="bootbox-confirm">对话框</button>-->
            <!--            <button class="btn btn-success  btn-sm" id="bootbox-options">表单</button>-->


        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?= MyGridView::widget([
            'data' => $dataUser,
            'pages' => $pages,
            'fieldInfo' => ['id'=>['label'=>'用户ID'],
                            'username'=>['label'=>'用户名'],
                            'name'=>['label'=>'姓名'],
                            'rname'=>['label'=>'角色'],
                            'status'=>['label'=>'禁用','value'=>function($d){
                                    return $d['status'] ? '是' : '否';
                                }],
                            'created_at'=>['label'=>'添加时间','value'=>function($d){
                                    return date('Y-m-d H:i:s',$d['created_at']);
                                }],
                            'updated_at'=>['label'=>'更新时间','value'=>function($d){
                                    return date('Y-m-d H:i:s',$d['updated_at']);
                                }],
                            'operate'=>['label'=>'操作','value'=>function($d){
                                    return '<a class="green" href="/admin/user/update.html?id=' . $d['id'] . '"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;<a class="red" href="#" onclick="gridViewConfirm(&quot;确定要删除吗？&quot;, &quot;/admin/user/delete.html?id=' . $d['id'] . '&quot;);"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>';
                                }]
                            ]
        ]); ?>
    </div>

</div>

