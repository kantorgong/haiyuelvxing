<?php
/**
 * GridView类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/18 20:35
 * @since    1.0
 */

namespace backend\components\grid;


class GridView extends \yii\grid\GridView
{
    public $layout = '{items}
    <div class="row">
                    <div class="col-md-5 col-sm-12">
                    <div class="dataTables_info" id="sample_2_info" role="status" aria-live="polite">
                     {summary}
                     </div>
                     </div>
                     <div class="col-md-7 col-sm-12">
                     <div class="dataTables_paginate paging_bootstrap_number" id="sample_2_paginate">
                     {pager}
                     </div></div>
                     </div>

                    ';

    public $pager = [
        'options' => [
            'class' => 'pagination'
        ]
    ];

    public $tableOptions = [
        'class' => 'table table-striped table-bordered table-advance table-hover'
    ];

    public $summary = '{begin}-{end}，共{totalCount}条数据，共{pageCount}页';
}