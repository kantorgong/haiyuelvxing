<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use fatjiong\daterangepicker\DateRangePicker as DateRangePicker;

$this->title = '错误日志';
?>

<div class="main-content-inner" style="width:99%">

    <div class="clearfix">
	    <?php if ($success = Yii::$app->session->getFlash('success')): ?>
	    <div class="alert alert-success alert-dismissable">
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		    <?=$success?>
	    </div>
	    <?php elseif ($error = Yii::$app->session->getFlash('error')): ?>
	    <div class="alert alert-danger alert-dismissable">
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		    <?=$error?>
	    </div>
	    <?php endif; ?>
        <div class="pull-left tableTools-container">
            <div class="nav-search" id="nav-search">
				<form method="post" action="" class="form-inline">
					<input type="text" name="name" class="form-control" required>
					<button class="btn btn-info">添加日志点</button>
					<button type="button" class="btn btn-danger" id="lookLog">隐藏日志点 <i class="fa fa-angle-double-down"></i></button>
				</form>
            </div>
        </div>
    </div>
	<br>
	<div class="portlet light tasks-widget bordered" id="lookShow">
		<div class="portlet-body util-btn-margin-bottom-5">
			<div class="clearfix">
				<blockquote>
					<p>点击对应日志点执行开启/关闭操作，红色状态即为已开启日志点，调试完毕请及时关闭日志，以免出现太多垃圾日志。</p>
				</blockquote>
				<?php
					$redis = Yii::$app->redis;
					if ($list):
				?>
				<?php foreach ($list as $l): ?>
				<?php
					if (!$l) continue;
					$val = $redis->hget($key, $l);
					$class = !$val ? 'blue btn-outline' : 'btn-danger';
				?>
				<button type="button" class="log-btn btn <?=$class?>"
				        onclick="gridViewConfirm('确定要修改日志状态吗？', '<?=\yii\helpers\Url::to(['error-log/update', 'key' => $l])?>');">
					<?=$l?></button>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'level',
                    'format' => 'raw',
                    'value' => function($model) {
                        $status = \components\helper\CommonUtility::getDictsList('error_log_type', 0, true);
                        switch ($model->level)
                        {
                            case 1:
                                $css = 'danger';
                                break;
                            case 2:
                                $css = 'warning';
                                break;
                            case 4:
                                $css = 'info';
                                break;
                            case 8:
                                $css = 'primary';
                                break;
                        }
                        return '<span class="label label-'. $css .'">'.$status[$model->level].'</span><br><br><span class="label label-default">编号：'.$model->id.'</span>';
                        },
                        'filter' => \components\helper\CommonUtility::getDictsList('error_log_type', 0, true),
                ],
                [
                    'attribute' => 'message',
	                'format' => 'raw',
	                'value' => function($data) {
                        return '<pre class="mt-code">' . date('Y-m-d H:i:s', $data['log_time']).
		                        "\r\n\r\n" . $data['prefix'] .
		                        "\r\n\r\n" . $data['message'] . '</pre>';
	                }
                ]
            ],
        ]); ?>

    </div>
</div>
<script>
    <?php
    ob_start();
    ?>

    var lookShowObj = $('#lookShow');
    var lookLogObj = $('#lookLog');
    lookLogObj.on('click', function() {
		if (lookShowObj.hasClass('hidden')) {
            lookLogObj.html('隐藏日志点 <i class="fa fa-angle-double-down"></i>');
			lookShowObj.removeClass('hidden');
		}
		else {
            lookLogObj.html('查看日志点 <i class="fa fa-angle-double-right"></i>');
            lookShowObj.addClass('hidden');
		}
    });

    <?php
    $js = ob_get_clean();
    $this->registerJs($js);
    ?>
</script>


