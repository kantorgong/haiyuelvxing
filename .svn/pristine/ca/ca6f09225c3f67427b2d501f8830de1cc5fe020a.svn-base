<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$this->title = $model->name . ' 分配权限';
$this->registerJsFile(Yii::getAlias('@web') . '/theme/maska/js/zTree/jquery.ztree.all-3.5.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile(Yii::getAlias('@web') . '/theme/maska/js/zTree/zTreeStyle.css');
?>




<div class="col-xs-11">
    <div class="page-header">
        <div class="pull-right tableTools-container">

            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                ['class' => 'btn btn-default', 'onclick' => 'window.location.href="'.Url::to(['index']).'"']) ?>
        </div>
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="panel-body">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin([
                'id' => 'role-priv-form',

            ]); ?>
            <ul id="treeDemo" class="ztree"></ul>
            <div class="form-group">
                <input type="button" id="btnSub" class="btn btn-primary" value="提交">
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>





<script language="JavaScript">
    var setting = {
        check: {
            enable: true,
            chkboxType: {"Y": "ps", "N": "ps"}
        },
        data: {
            simpleData: {
                enable: true
            }
        }
    };
    var zNodes = <?php echo json_encode($menus); ?>;
    <?php
   ob_start();
   ?>
    var csrfToken = $("input[name='_csrf']").val()
    var treeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    $('#btnSub').click(function() {
        nodes = treeObj.getCheckedNodes(true);
        if (nodes.length > 0) {
            var menus = {"menu_id": [],"_csrf":csrfToken};
            $.each(nodes, function(i, n) {
                menus.menu_id[i] = n.id;
            });
            $.post("<?= Yii::$app->getRequest()->getUrl(); ?>", menus,
                function(data) {
                    if (data.status)
                        window.parent.gritterAlert(data.message, '请重试或联系管理员', 'gritter-error');
                    else{
                        window.parent.gritterAlert(data.message, '', 'gritter-success');
                        window.location.reload();
                    }
                }, "json");
        } else {
            alert('请选择节点！');
        }
        return false;
    });

    <?php
        $js = ob_get_clean();
        $this->registerJs($js);
        ?>
</script>


