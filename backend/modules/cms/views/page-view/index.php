<?php

use yii\helpers\Html;
use backend\components\grid\GridView;

$this->title = '访问次数管理';
$this->registerJsFile('https://cdn.bootcss.com/clipboard.js/1.6.1/clipboard.min.js');
?>
<div class="main-content-inner" style="width:99%">
<div class="hide" id="copyText">
	var _pageView = _pageView || 0;
	(function() {
	    var pv = document.createElement("script");
	    pv.src = "http://plus.xxcb.cn/activity/page-view/js.html?{guid}";
	    var s = document.getElementsByTagName("script")[0];
	    s.parentNode.insertBefore(pv, s);
	})();
</div>
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <?= Html::a('新建访问页面', ['create'], ['class' => 'btn blue']) ?>
            </div>
        </div>
        <div class="portlet-body">
            <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'guid',
                            'label' => 'GUID',
                            'value' => function ($data)
                            {
                                return $data['guid'];
                            },
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'filterInputOptions' => ['style' => 'width:150px'],
                            'filterOptions' => ['style' => 'width: 150px;'],
                        ],
                        'title',
	                    'link',
	                    'view',
	                    'show',
                        [
                            'attribute' => 'insert_time',
                            'label' => '添加时间',
                            'value' => function ($data)
                            {
                                return $data['insert_time'] && $data['insert_time'] ? date("Y-m-d H:i:s", $data['insert_time']) : '-';
                            }
                        ],
                        [
                            'attribute' => 'insert_id',
                            'label' => '添加人',
                            'value' => function ($model)
                            {
                                if (!$model->insert_id) return '-';
                                return $model->insertor->name;
                            }
                        ],
                        [
                            'attribute' => 'modify_time',
                            'label' => '修改时间',
                            'value' => function ($data)
                            {
                                return $data['modify_time'] && $data['modify_time'] ? date("Y-m-d H:i:s", $data['modify_time']) : '-';
                            }
                        ],
                        [
                            'attribute' => 'modify_id',
                            'label' => '修改人',
                            'value' => function ($model)
                            {
                                if (!$model->modify_id) return '-';
                                return $model->modifior->name;
                            }
                        ],
                        [
                            'class' => 'backend\components\grid\ActionColumn',
                            'header' => '操作',
                            'options' => ['width' => '50px;'],
                            'template' => '{update} {delete} {copy}',
	                        'buttons' => [
	                        		'copy' => function($url, $data) {
                                        return '<button class="btn btn-outline btn-sm yellow copy" data-guid="'.$data['guid'].'">复制代码</button>';
			                        }
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
    <?php
    ob_start();
    ?>
    var clipboard = new Clipboard('.copy', {
        text: function(trigger) {
            var guid = trigger.getAttribute('data-guid');
            return '<script>' + $('#copyText').html().replace('{guid}', guid) + '<\/script>';
        }
    });

    clipboard.on('success', function(e) {
        window.parent.xcms_notific('', '代码复制成功，请将代码复制到body之前，并且在页面加载完成之后再获取参数_pageView。', 'success');
        e.clearSelection();
    });

    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>

