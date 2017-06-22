<?php

/**
 * @filename OftenController.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 16:22:57
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\models\Applyoption;
use common\models\search\ApplyoptionSearch;
use components\helper\CommonUtility;
use components\XyXy;
use yii\web\Controller;

class OftenController extends \backend\modules\cms\components\Controller
{

    /**
     * 检索全部
     */
    public function actionIndex()
    {
        $searchModel = new ApplyoptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * 添加
     */
    public function actionCreate()
    {
        $mod = new Applyoption();
        $ajax = $mod->load($_POST);
        if(!$ajax)
            return $this->render('create', ['model' => $mod]);
        
        $mod->insert_id = Yii::$app->user->identity->id;
        $mod->insert_time = time();
        $mod->modify_id = '0';
        $mod->modify_time = '0';
        $ret = $mod->save();
        if(FALSE === $ret)
            throw new NotFoundHttpException('添加失败!');
        return $this->redirect(['index']);
    }

    /**
     * 联动
     */
    public function actionTypes()
    {
        $type = Yii::$app->request->get('label');
        
        $options = "<option value=''> 可空 </option>";
        if('input' == $type)
        {
            $options = "<option> 请选择 </option>";
            $types = ['text' => '文本', 'checkbox' => '复选', 'radio' => '单选', 'date' => '日期'];
            foreach ($types as $key => $value)
            {
                $options .= "<option value='{$key}'>{$value}</option>";
            }
        }
        echo $options;
    }
    
    /**
     * 修改
     */
    public function actionUpdate()
    {
        $mod = new Applyoption();
        $id = intval(\Yii::$app->request->get("id"));
        $option = $mod->findOne(['id' => $id]);
        $ajax = $option->load($_POST);
        if(!$ajax)
            return $this->render('update', ['model' => $option]);
        
        $option->modify_id = Yii::$app->user->identity->id;
        $option->modify_time = time();
        $ret = $option->save();
        if(FALSE === $ret)
            throw new NotFoundHttpException('修改失败!');
        return $this->redirect(['index']);
    }

}

?>