<?php
/**
 * 修改自己信息试图
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/30 14:53
 * @since    1.0
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->registerJsFile(Yii::getAlias('@web') . '/theme/ace/dist/js/ajaxfileupload.js');

$role = Yii::$app->db
        ->createCommand('SELECT item_name FROM auth_item left join auth_assignment on item_name = name  WHERE user_id = '.\Yii::$app->user->identity->id.' and type = 1')
        ->queryAll();
$roleName = '';
if ($role)
{
    foreach ($role as $r)
    {
        $roleName[] = $r['item_name'];
    }
    $roleName = join('、', $roleName);
}

?>

<div class="main-content-inner" style="width:99%">
    <div class="portlet">
        <div class="page-header">
            <div class="pull-right tableTools-container">
            </div>
            <h3 class="page-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="portlet-body">
            <div class="form-horizontal">
                <?php
                $disabled = $model->isNewRecord ? null : 'disabled';
                $form = ActiveForm::begin([
                        'id' => $model->formName(),
                ]);
                ?>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">头像</label>
                        <div class="col-sm-9">
                            <div style="display:none">
                                <input type="file" id="upload" name="avatar"/>
                                <input type="hidden" id="input_pic" name="avatar" value="<?=\Yii::$app->user->identity->avatar?>"/>
                            </div>
                            <img id="upload_pic" data-name="img" style="max-height: 300px; max-width: 300px;"
                                 src="<?=\components\XyXy::formatAvatar(\Yii::$app->user->identity->avatar)?>"/>
                            <span class="btn blue" id="upload">上传</span>
                        <span class="label label-default">仅限上传.jpg .gif .png .jpeg格式图片，大小不能超过
                            <?=ceil(\backend\modules\admin\controllers\UserController::AVATAR_SIZE/1024)?>KB
                        </span>
                        </div>
                    </div>
                    <?= $form->field($model, 'username', [
                                    'template' => '{label}
                                        <div class="col-sm-3">
                                            {input}
                                            <span class="help-inline col-xs-12 col-sm-7">
                                                        <span class="middle">{hint}{error}</span>
                                                    </span>
                                        </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control',
                            'readonly' => 'readonly'
                    ])
                    ?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">角色</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?=$roleName?>" readonly="readonly">
                        </div>
                    </div>

                    <?php if ($model->scenario == 'update'): ?>
                        <?= $form->field($model, 'password', [
                                        'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        <span class="help-inline col-xs-12 col-sm-7">
                                                    {hint}{error}
                                                </span>
                                    </div>',
                                        'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                        'parts' => ['{hint}' => '<div class="help-inline" style="float: left; margin: 5px">不修改请留空</div>'],
                                ]
                        )->passwordInput([
                                'maxlength' => true,
                                'class' => 'form-control',
                                'value' => ''
                        ])
                        ?>
                    <?php else: ?>
                        <?= $form->field($model, 'password', [
                                        'template' => '{label}
                                    <div class="col-sm-3">
                                        {input}
                                        <span class="help-inline col-xs-12 col-sm-7">
                                                    <span class="middle">{hint}{error}</span>
                                                </span>
                                    </div>',
                                        'labelOptions' => ['class' => 'col-sm-3 control-label'],
                                ]
                        )->passwordInput([
                                'maxlength' => true,
                                'class' => 'form-control',
                        ])
                        ?>
                    <?php endif; ?>
                    <?= $form->field($model, 'name', [
                                    'template' => '{label}
                                        <div class="col-sm-3">
                                            {input}
                                            <span class="help-inline col-xs-12 col-sm-7">
                                                        <span class="middle">{hint}{error}</span>
                                                    </span>
                                        </div>',
                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ]
                    )->textInput([
                            'maxlength' => true,
                            'class' => 'form-control',
                    ])
                    ?>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">

                            <?= Html::submitButton($model->isNewRecord ? '<i class="ace-icon fa fa-check bigger-110"></i>新增' :
                                    '<i class="ace-icon fa fa-pencil bigger-110"></i> 修改',
                                    ['class' => $model->isNewRecord ? 'btn blue' : 'btn green']) ?>


                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


    <script language="javascript">
        <?php
        ob_start();
        ?>

        jQuery('form#User').on('beforeSubmit', function (e) {
            var $form = $(this);

            $.post('<?= Url::to(['updateme']); ?>', $form.serialize(), function (data) {

                if (data.status)
                    window.parent.xcms_notific('操作失败, 请重试或联系管理员', "ruby");
                else if (!data.status) {
                    window.parent.xcms_notific(data.message, "lime");
                    window.location.reload();
                }
            }, "json");
            return false;
        });

        $("input#upload").change(function () {
            $.ajaxFileUpload({
                url: '<?=Url::to(['user/avatar'])?>',
                secureuri: false,
                fileElementId: "upload",
                dataType: "json",
                data: '<?=json_encode(['thumb' => 0])?>',
                success: function (data, status) {
                    if (data.code === 0) {
                        $("#upload_pic").attr("src", data.data.url);
                        $("#input_pic").val(data.data.url);
                    }
                    else
                    {
                        window.parent.xcms_notific(data.msg, "ruby");
                    }
                },
                error: function (data, status, e)
                {
                    return false;
                }
            });
        });

        $("span#upload").click(function() {
            $("input#upload").click();
        });

        <?php
        $js = ob_get_clean();
        $this->registerJs($js);
        ?>
    </script>