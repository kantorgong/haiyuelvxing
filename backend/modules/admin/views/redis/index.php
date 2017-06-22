<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'redis';
?>

<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">

        </div>
        <div class="pull-left tableTools-container">
            <form method="get">
                <div style="float: left;">
                    <input type="text" class="form-control" name="key"  style="width: 300%" value="<?= Yii::$app->request->get('key')?>">
                </div>
                <div style="float: right;margin-left: 286px;">
                    <button type="submit" class="btn blue" ><i class="fa fa-search bigger-110"></i> 搜索</button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-header"></div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <div id="w0" class="grid-view">
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>键名称</th>
                            <th>键值</th>
                            <th style="width:300px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key=>$value):?>
                    <tr data-key="1">
                        <td ><?= $key+1?></td>
                        <td><?= $value?></td>
                        <td ><?php
                            $type = Yii::$app->redis->type($value);
                            $val = $keyType[$type];
                            if(empty($val))
                            {
                                echo Yii::$app->redis->get($value);
                            }
                            else
                            {
                                echo $val;
                            }
                        ?></td>
                        <td class="hidden-sm hidden-xs action-buttons" style="text-align: left;">
                            <?php if(empty($val)):?>
                                <a class="btn btn-outline btn-sm green" href="<?= Url::to(['redis/update','key'=>$value])?>" title="更新">更新</a>
                            <?php else:?>
                                <a class="btn btn-outline btn-sm blue" href="<?= Url::to(['redis/list','key'=>$value])?>" title="查看">查看</a>
                            <?php endif;?>
                                <a class="btn btn-outline btn-sm red" href="#" onclick="gridViewConfirm('确定要删除 “<?= $value ?>” 的值吗？请慎重哦！', '<?= Url::to(['redis/ajax-del','key'=>$value])?>');" title="删除">删除</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <div class="dataTables_info" id="sample_2_info" role="status" aria-live="polite">
                            共<?= \Yii::$app->session['redisCount'];?>条数据
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12">
                        <div class="dataTables_paginate paging_bootstrap_number" id="sample_2_paginate">
                            <ul class="pagination">
                                <li><a href="<?= Url::to(['redis/index','key'=>Yii::$app->request->get('key'),'page'=>0])?>" data-page="0">首页</a></li>
                                <li class="next"><a href="<?= Url::to(['redis/index','key'=>Yii::$app->request->get('key'),'page'=>'pre'])?>" data-page="0">上一页</a></li>
                                <?php if(empty($list)):?>
                                    <li class="next disabled"><span>尾页</span></li>
                                <?php else:?>
                                    <li class="next"><a href="<?= Url::to(['redis/index','key'=>Yii::$app->request->get('key'),'page'=>'next'])?>" data-page="1">下一页</a></li>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>