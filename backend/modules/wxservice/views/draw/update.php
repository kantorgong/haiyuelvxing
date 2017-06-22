<?php
/**
 * @filename update.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-4-7 16:53:03
 * @version 1.0
 * @copyright (c) 2016-4-7, 潇湘晨报（版权）
 * @access public 权限
 */
$this->title = '修改微信活动';
?>

<?php echo $this->render('_form', ['model' => $model, 'prizes' => $prizes]); ?>