<?php
use yii\helpers\Html;
use backend\components\grid\GridView;

$this->title = '用户管理';
$start_time = Yii::$app->memcached->get('love_user:start_time')?:0;
$day = Yii::$app->memcached->get('love_user:day')?:0;
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">

            </div>
        </div>
        <div class="pull-left tableTools-container">
            <form class="form-inline">
                <div class="form-group">
                    <label>开启时间：</label>
                    <input type="text" class="form-control datetime-picker" value="<?=$start_time?date('Y-m-d H:i', $start_time):''?>" id="start_time">
                </div>
                <div class="form-group">
                    <label>设置天数（仅用于测试）：</label>
                    <input type="text" class="form-control" value="<?=$day?>" id="day">
                </div>
                <button type="button" onclick="gridViewConfirm('确定要更新开启时间吗？', '<?=\yii\helpers\Url::to(['open'])?>?start_time=' + $('#start_time').val() + '&day=' + $('#day').val())"
                        class="btn btn-default blue">确定</button>&nbsp;&nbsp;<span class="label-danger" style="color: #fff">标签关键字请用英文逗号分隔！</span>
            </form>
        </div>
    </div>
    <div class="table-header">
    </div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'uid',
                    'contentOptions' => ['style' => 'width: 50px;'],
                    'filterInputOptions' => ['style' => 'width: 50px', 'class' => 'form-control']
                ],
                'nickname',
                [
                    'attribute' => 'sex',
                    'contentOptions' => ['style' => 'width: 50px;'],
                    'filterInputOptions' => ['style' => 'width: 50px', 'class' => 'form-control']
                ],
                [
                    'attribute' => 'orientation',
                    'contentOptions' => ['style' => 'width: 50px;'],
                    'filterInputOptions' => ['style' => 'width: 50px', 'class' => 'form-control']
                ],
                'birth',
                'constellation',
                'hobby',
                [
                    'attribute' => 'mark',
                    'format' => 'raw',
                    'value' => function($model) {
                        return '<textarea title="多个标签请用英文逗号分隔！" id="mark_'.$model->uid. '" class="form-control">'.$model->mark.'</textarea>';
                    }
                ],
                'description',
                'phone',
                'wechat',
                [
                        'attribute' => 'photo',
                        'label' => '照片',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->photo ? '<a href="'.$model->photo.'" target="_blank"><img src="'.$model->photo.'" width="80" height="80"></a>' : '-';
                        }
                ],
                [
                    'label' => '激活任务',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if(!$model['active_time'])
                            return '<span class="label label-default">否</span>';
                        else
                            return '<span class="label label-success">是</span>';
                    },
                ],
                [
                    'attribute' => 'mate_uid',
                    'label' => '配对',
                    'format' => 'raw',
                    'value' => function ($model) use ($rtUser) {
                        $html = '<select class="form-control" id="mid_'.$model->uid. '">
                                 <option value=""></option>';
                        foreach ($rtUser as $k => $u)
                        {
                            $select = $k == $model->mate_uid ? 'selected' : '';
                            $html .= '<option value="'.$k.'" '.$select.'>'.$u.'</option>';
                        }
                        $html .= '</select>';

                        return $html;
                    },
//                    'filter' => Html::activeDropDownList($searchModel, 'mate_uid', array_merge(['' => ''], $rtUser), ['class' => 'form-control']),
                ],
                [
                    'class' => 'backend\components\grid\ActionColumn',
                    'template' => '{mate}',
                    'buttons' => [
                        'mate' => function ($url, $data, $model)
                        {
                            //gridViewConfirm("确定要更新吗？", "'.$url.'&mid=" + $("mid_" + '.$data->uid.').val());
                            $url = \yii\helpers\Url::toRoute(['love/mate', 'uid' => $data->uid]);
                            return $model->active_time ? Html::a('立即更新', '#', [
                                    'title' => Yii::t('yii', '立即更新'),
                                    'class' => 'btn btn-outline btn-sm blue',
                                    'onclick' => 'alert("任务已激活，无法修改！")'
                            ]) : Html::a('立即更新','#', [
                                    'title' => Yii::t('yii', '立即更新'),
                                    'class' => 'btn btn-outline btn-sm blue',
                                    'onclick' => 'gridViewConfirm("确定要更新吗？如果用户已配对，之前的配对将被取消！", "'.$url.'&mark=" + $("#mark_" + '.$data->uid.').val() + "&mid=" + $("#mid_" + '.$data->uid.').val());'
                            ]);
                        },
                    ],
                    'header'=>'操作',
                ],
            ],
        ]); ?>
    </div>
</div>
<script>
    <?php
    ob_start();
    ?>

    $('.datetime-picker').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    }).on('changeDate', function (ev) {
        $(this).datetimepicker('hide');
    });

    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>