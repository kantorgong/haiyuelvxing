<?php
/**
 * 名称
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/18 20:33
 * @since    1.0
 */

namespace backend\components\grid;

use Yii;
use Closure;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = "{update} {delete}";

    public $headerOptions = [
        'style' => 'text-align: center; width:150px; color:#707070'
    ];

    public $contentOptions = [
        'style' => 'text-align: left;',
        'class' => 'hidden-sm hidden-xs action-buttons',
    ];
    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {


        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<i class="fa fa-search-plus bigger-130"></i> ', $url, [
                    'title' => Yii::t('yii', '查看'),
                    'class' => 'blue'
                ]);
            };
        }



        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model) {
                return Html::a('更新', $url, [
                    'title' => Yii::t('yii', '更新'),
                    'class'=>'btn btn-outline btn-sm green'
                ]);
            };
        }


        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('删除','#', [
                    'title' => Yii::t('yii', '删除'),
//                    'data-confirm' => Yii::t('yii', '确定删除这条数据?'),
//                    'data-method' => 'post',
                    'class' => 'btn btn-outline btn-sm red',
                    'onclick' => 'gridViewConfirm("确定要删除吗？", "'.$url.'");'
                ]);
            };
        }
    }
}