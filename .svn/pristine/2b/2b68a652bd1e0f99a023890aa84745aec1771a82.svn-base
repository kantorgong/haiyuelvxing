<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'redis';
?>

<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回',
                ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"']) ?>
        </div>
        <div class="pull-left tableTools-container">
            <form method="post">
                <div style="float: left;">
                    <input type="hidden" name="key" value="<?= Yii::$app->request->get('key')?>"/>
                    <input type="text" name="id" class="form-control" style="width: 300%" value="<?= Yii::$app->request->post('id')?>"/>
                    <input type="hidden" name="keyType" value="<?= $keyType?>"/>
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
                    <th colspan="4" style="text-align: center"><?=Yii::$app->request->get('key')?>  列表值</th>
                </tr>
                <tr>
                    <th>序号</th>
                    <th>键名称</th>
                    <th>键值</th>
                    <th style="width:300px;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if($keyType == 'hash'):?>
                    <?php foreach($list as $key=>$value):?>
                        <?php if($key%2 == 1) continue;
                            $i = floor($key/2);
                        ?>
                        <tr data-key="1">
                            <td ><?= $i+1?></td>
                            <td><?= $list[$key];?></td>
                            <td ><?= $list[$key+1]?></td>
                            <td class="hidden-sm hidden-xs action-buttons" style="text-align: left;">
                                <a class="btn btn-outline btn-sm green" href="<?= Url::to(['redis/edit','key'=>Yii::$app->request->get('key'),'id'=>$list[$key],'type'=>'hash'])?>" title="更新">更新</a>
                                <a class="btn btn-outline btn-sm red" href="#" onclick="gridViewConfirm('确定要删除哈希中 “<?= $list[$key] ?>” 的值吗？请慎重哦！', '<?= Url::to(['redis/ajax-iddel','key'=>Yii::$app->request->get('key'),'id'=>$list[$key],'type'=>'hash'])?>');" title="删除">删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php elseif($keyType == 'list'):?>
                    <?php foreach($list as $key=>$value):?>
                        <tr data-key="1">
                            <td ><?= $key+1?></td>
                            <td><?= $key;?></td>
                            <td ><?= $value;?></td>
                            <td class="hidden-sm hidden-xs action-buttons" style="text-align: left;">
                                <a class="btn btn-outline btn-sm green" href="<?= Url::to(['redis/edit','key'=>Yii::$app->request->get('key'),'id'=>$key,'type'=>'list'])?>" title="更新">更新</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php elseif($keyType == 'zset'):?>
                    <?php foreach($list as $key=>$value):?>
                        <tr data-key="1">
                            <td ><?= $key+1?></td>
                            <td>&nbsp;</td>
                            <td ><?= $value;?></td>
                            <td class="hidden-sm hidden-xs action-buttons" style="text-align: left;">
                                <a class="btn btn-outline btn-sm red" href="#" onclick="gridViewConfirm('确定要删除集合元素 “<?= Html::encode($value) ?>” 吗？请慎重哦！', '<?= Url::to(['redis/ajax-iddel','key'=>Yii::$app->request->get('key'), 'id'=>Html::encode($value), 'type'=>'zset'])?>');" title="删除">删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php elseif($keyType == 'set'):?>
                    <?php foreach($list as $key=>$value):?>
                        <tr data-key="1">
                            <td ><?= $key+1?></td>
                            <td>&nbsp;</td>
                            <td ><?= $value;?></td>
                            <td class="hidden-sm hidden-xs action-buttons" style="text-align: left;">
                                <a class="btn btn-outline btn-sm red" href="#" onclick="gridViewConfirm('确定要删除集合元素 “<?= Html::encode($value) ?>” 吗？请慎重哦！', '<?= Url::to(['redis/ajax-iddel','key'=>Yii::$app->request->get('key'), 'id'=>Html::encode($value), 'type'=>'set'])?>');" title="删除">删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <div class="dataTables_info" id="sample_2_info" role="status" aria-live="polite">
                        共<?php if($keyType == 'hash')
                        {
                            echo floor(\Yii::$app->session['redisCount']/2);
                        }else{
                            echo \Yii::$app->session['redisCount'];
                        }?>条数据
                    </div>
                </div>
                <div class="col-md-7 col-sm-12">
                    <div class="dataTables_paginate paging_bootstrap_number" id="sample_2_paginate">
                        <?php if(!Yii::$app->request->isPost):?>
                        <ul class="pagination">
                            <li><a href="<?= Url::to(['redis/list','key'=>Yii::$app->request->get('key'),'page'=>0])?>" data-page="0">首页</a></li>
                            <li class="next"><a href="<?= Url::to(['redis/list','key'=>Yii::$app->request->get('key'),'page'=>'pre'])?>" data-page="0">上一页</a></li>
                            <?php if(empty($list)):?>
                                <li class="next disabled"><span>尾页</span></li>
                            <?php else:?>
                                <li class="next"><a href="<?= Url::to(['redis/list','key'=>Yii::$app->request->get('key'),'page'=>'next'])?>" data-page="1">下一页</a></li>
                            <?php endif;?>
                        </ul>
                        <?php endif;?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>