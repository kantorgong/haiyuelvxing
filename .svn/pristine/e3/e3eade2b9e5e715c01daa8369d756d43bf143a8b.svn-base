<?php
/**
* @作者：limj(李绵军)
* @描述：自定义小物件
* @名称：MyGridView.php
* @版本：1.0
* @时间：15-12-24
*/
namespace backend\modules\admin\widget;
class MyGridView extends \yii\grid\GridView
{
    public $data;
    public $fieldInfo;
    public $pages;
    /**
     * 描述：初始化值
     */
    public function init()
    {
        if ($this->data === null)
        {
            $this->data = array();
        }
    }

    /**
     * 描述：运行小物件
     */
    public function run()
    {
        return $this->render('table',array('dataUser'=>$this->data,
                                           'fieldInfo'=>$this->fieldInfo,
                                           'pages'=>$this->pages,
        ));
    }
}