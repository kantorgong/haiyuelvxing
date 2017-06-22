<?php

/**
 * @filename applyer.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-23 11:21:49
 * @version 1.0
 * @copyright (c) 2016-3-23, 潇湘晨报（版权）
 * @access public 权限
 */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "{$apply['title']}报名人员";
?>
<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="col-xs-12">
    <div class="page-header">
        <div class="pull-right tableTools-container">
            <?= Html::Button('<i class="ace-icon fa fa-reply icon-only"></i>返回', 
                    ['class' => 'btn btn-default', 'onclick' => 'window.location.href="' . Url::to(['index']) . '"'])
            ?>
            <?php if (!empty($applyers)){?><?= Html::Button('<i class="ace-icon fa icon-only"></i>导出excel', 
                    ['class' => 'btn btn-white btn-success', 'onclick' => 'window.location.href="' . Url::to(['applyer']) . '?type=excel&id='.$apply['id'].'"'])
            ?>
            <?php }?>
        </div>
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
    </div>
    <?php if (empty($applyers)){?>
    <div class="col-xs-12">
          <h3> 暂无报名数据 </h3>
    </div>
    <?php }else{?>
    <table class="table table-striped m-b-none dataTable">
        <tr class="tb_header">
            <th width="60px">编号</th>
            <?php foreach ($applyers[0]['info_values'] as $key=>$fo): ?>
            <th width="150px"><?=$key?></th>
            <?php endforeach; ?>
            <th width="100px">微信openid</th>
            <th width="100px">微信昵称</th>
            <th width="100px">报名时间</th>
        </tr>
        <?php foreach ($applyers as $row): ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <?php 
                $html = '';
                //var_dump($row->info_values);
                foreach ($row['info_values'] as $fo)
                {
//                     $va = array_pop($fo);
                    if(is_array($fo))
                        $fo = implode(",", $fo);
                    $html .= "<td>{$fo}</td>";
                }
                echo $html;
                ?>
                <td><?php echo $row['openid']?></td>
                <td><?php echo $row['nickname']?></td>
                <td><?php if(0 < intval($row['insert_time']))echo date("Y-m-d H:i:s", $row['insert_time'])?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php }?>
</div>