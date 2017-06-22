<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '菜单';
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <?= Html::a('新建' . $this->title, ['create'], ['class' => 'btn btn-success btn-sm']) ?>

        </div>
    </div>

    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()); ?>
    <table class="table table-striped m-b-none dataTable">
        <thead>
        <tr>
            <th>排序</th>
            <th>菜单名</th>
            <th>显示</th>
            <th>链接</th>

            <th style="text-align: center; width:150px;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?= $lists ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">
                <?= Html::button('排序', ['class' => 'btn btn-success  btn-sm', 'id' => 'orderBtn']) ?>
            </td>
        </tr>
        </tfoot>
    </table>
</div>

<script language="javascript">
    <?php
    ob_start();
    ?>

    $("#orderBtn").click(function () {

        var formdata = {
            '<?= Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
            'listorders': {}
        };

        $('.listorders').each(function (i, input) {
            formdata.listorders[$(input).attr('vid')] = $(input).val();
        });
        $.post('<?= Url::to(['listorder']); ?>', formdata, function (data) {

            if (data.status)
                window.parent.gritterAlert('操作失败', '请重试或联系管理员', 'gritter-error');
            else if (!data.status) {
                window.parent.gritterAlert(data.message, '', 'gritter-success');
                window.location.reload();
            }
        }, "json");
        return false;
    });
    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>

