<?php

/**
 * @filename ApplyController.php 
 * @encoding UTF-8 
 * @author zhengzp 
 * @copyright xxcb 
 * @license xxcb
 * @datetime 2016-3-17 10:59:59
 * @version 1.0
 * @copyright (c) 2016-3-17, 潇湘晨报（版权）
 * @access public 权限
 */

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Applyoption;
use common\models\Apply;
use common\models\search\ApplySearch;
use common\models\Applyinfo;
use components\helper\Excel;

class ApplyController extends \backend\modules\cms\components\Controller
{

    public function actionIndex()
    {
        $searchModel = new ApplySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    public function actionCreate()
    {
        $mod = new Apply();
        $ofen_mod = new Applyoption();
        $options = $ofen_mod->findAll(['is_use' => 1]);
        $ajax = $mod->load($_POST);
        if(!$ajax)
            return $this->render('create', ['model' => $mod, 'options' => $options]);
        
        if(empty($_POST['Apply']['forms']))
            throw new NotFoundHttpException('请勾选表单');
        $mod->insert_id = Yii::$app->user->identity->id;
        $mod->insert_time = time();
        $mod->start_time = strtotime($mod->start_time);
        $mod->end_time = strtotime($mod->end_time);
        if(1 > $mod->start_time || 1 > $mod->end_time)
            throw new NotFoundHttpException('开始报名时间和报名截止时间不能为空');
        if($mod->start_time > $mod->end_time)
            throw new NotFoundHttpException('开始报名时间不能早于报名截止时间');
        $mod->modify_id = '0';
        $mod->modify_time = '0';
        
        $forms = array();
        foreach ($options as $opt)
        {
            if(!in_array($opt->id, $mod->forms))
                continue;
            $forms[$opt->id] = array('text' => $opt->info_title, 'name' => $opt->info_name, 'label' => $opt->info_label, 'type' => $opt->info_type, 'options' => $opt->options);
        }
        $mod->forms = addslashes(json_encode($forms));
        $mod->title = addslashes($mod->title);
        $mod->summary = addslashes($mod->summary);
        $mod->guid = \components\helper\CommonUtility::createGuid();
        
        $ret = $mod->save();
        if(FALSE === $ret)
            throw new NotFoundHttpException('添加失败!');
        return $this->redirect(['index']);
    }
    
    public function actionUpdate()
    {
        $mod = new Apply();
        $ofen_mod = new Applyoption();
        $options = $ofen_mod->findAll(['is_use' => 1]);
        $id = intval(\Yii::$app->request->get("id"));
        $option = $mod->findOne(['id' => $id]);
        $ajax = $option->load($_POST);
        if(!$ajax)
        {
            $option->forms = stripslashes($option->forms);
            $option->title = stripslashes($option->title);
            $option->summary = stripslashes($option->summary);
            return $this->render('update', ['model' => $option, 'options' => $options]);
        }
        if(empty($_POST['Apply']['forms']))
            throw new NotFoundHttpException('请勾选表单');
        
        $option->start_time = strtotime($option->start_time);
        $option->end_time = strtotime($option->end_time);
        
        if(1 > $option->start_time || 1 > $option->end_time)
            throw new NotFoundHttpException('开始报名时间和报名截止时间不能为空');
        if($option->start_time > $option->end_time)
            throw new NotFoundHttpException('开始报名时间不能早于报名截止时间');
        
        $forms = array();
        foreach ($options as $opt)
        {
            if(!in_array($opt->id, $option->forms))
                continue;
            $forms[$opt->id] = array('text' => $opt->info_title, 'name' => $opt->info_name, 'label' => $opt->info_label, 'type' => $opt->info_type, 'options' => $opt->options);
        }
        $option->forms = addslashes(json_encode($forms));
        $option->title = addslashes($option->title);
        $option->summary = addslashes($option->summary);
        $option->modify_id = Yii::$app->user->identity->id;
        $option->modify_time = time();
        !$option->guid && $option->guid = \components\helper\CommonUtility::createGuid();
        $ret = $option->save();
        if(FALSE === $ret)
            throw new NotFoundHttpException('修改失败!');
        return $this->redirect(['index']);
    }
    
    public function actionForm()
    {
        $id = intval(\Yii::$app->request->get("id"));
        $mod = new Apply();
        $option = $mod->findOne(['id' => $id]);
        $option->forms = stripslashes($option->forms);
        return $this->render('form', ['model' => $option]);
    }
    
    public function actionApplyer()
    {
        $id = intval(\Yii::$app->request->get("id"));
        $type = \Yii::$app->request->get("type");
        $mod = new Applyinfo();
        $applyes = $mod::find()
                ->where(['apply_id' => $id])
                ->asArray()
                ->all();
        
        $apply_mod = new Apply();
        $option = $apply_mod::find()
                ->select('id,title,forms')
                ->where(['id' => $id])
                ->asArray()
                ->one();
        $option['forms'] = json_decode(stripslashes($option['forms']));
        
        foreach ($applyes as $key => $value)
        {
            $value['info_values'] = json_decode($value['info_values'], TRUE);
            $applyes[$key] = $value;
        }
        
        //消除变量
        unset($mod);
        unset($apply_mod);
        
        //导出excel
        if ($type == 'excel')
        {
            $this->addExcel($applyes, $option);die;
        } 
        //渲染页面
        return $this->render("applyer", ['applyers' => $applyes, 'apply' => $option]);
    }
    
    private function addExcel($applyes, $option)
    {
        /* $data = array(
                array('姓名','标题','文章','价格','数据5','数据6','数据7'),
                array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
                array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
                array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
                array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
                array('数据1','数据2','数据3','数据4','数据5','数据6','数据7')
        ); */
        //头部
        $title = array();
        $title[] = '编号';
        foreach ($applyes[0]['info_values'] as $key=>$fo)
        {
            $title[] = $key;
        }
        $title[] = '微信openid';
        $title[] = '微信昵称';
        $title[] = '报名时间';
        
        //设置文件基本信息
        $creator = array(
                "creator" => yii::$app->user->identity->id,
                "modify" => yii::$app->user->identity->id,
                "descrip" => "导出有报名名单",
                "title" => "报名名单",
                "subject" => "报名名单",
                "file_name" => $option['title'] . '报名人员名单' . date('Y-m-d'),
        ); 
        
        $data = array();
        
        //内容
        foreach ($applyes as $log)
        {
            $info = array();
            $info[] = $log['id'];
            foreach ($log['info_values'] as $fo)
            {
                $info[] = $fo;
            }
            $info[] = $log['openid'];
            $info[] = $log['nickname'];
            $info[] = date("Y-m-d H:i:s", $log['insert_time']);
            $data[] = $info;
            unset($info);
            ob_flush();
            flush();
        }
        unset($applyes);
        unset($option);
        $excel = new Excel(count($title));
        $excel->init($creator);
        $excel->setTitles($title);
        
        $excel->pushDatas($data);
        $excel->export(); 
        exit();
        /* $excel = new Excel();
        $fileName = $option['title'] . '报名人员名单' . date('Y-m-d h:i');
        $excel->download($data, $fileName);die; */
    }
}

?>