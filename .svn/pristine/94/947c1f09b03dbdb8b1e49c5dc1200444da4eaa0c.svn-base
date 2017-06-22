<?php
use yii\widgets\LinkPager;//使用显示分页类
?>
<div id="w0" class="grid-view">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <?php foreach($fieldInfo as $info):?>
                <th><a href="#"><?php echo $info['label'];?></a></th>
                <?php endforeach;?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($dataUser as $value):?>
            <tr>
                <?php foreach($fieldInfo as $key=>$val):?>
                    <td><?php   if ($val['value'])
                        {
                            echo $val['value']($value);
                        }
                        else
                        {
                            echo $value[$key];
                        }
                        ?>
                    </td>
                <?php endforeach;?>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<?php if($pages):?>
<div id="custom-pagination">
    <?php
    echo LinkPager::widget([
        'pagination' => $pages,
        'firstPageLabel'=>'首页',
        'lastPageLabel'=>'末页',
    ]);
    ?>
</div>
<?php endif;?>