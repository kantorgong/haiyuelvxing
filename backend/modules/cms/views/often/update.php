<?php

/**
 * @filename update.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-18 17:53:10
 * @version 1.0
 * @copyright (c) 2016-3-18, 潇湘晨报（版权）
 * @access public 权限
 */

$this->title = '修改表单';
?>
<div class="catalog-create">
	<?php echo $this->render('_form', ['model' => $model, 'action' => $action]); ?>
</div>