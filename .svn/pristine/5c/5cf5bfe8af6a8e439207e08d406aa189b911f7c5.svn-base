<?php

namespace common\models\config;

use Yii;
use yii\base\Model;
use components\db\BaseModel;
use components\helper\CacheUtility;

/**
 * LoginForm is the model behind the login form.
 */
class BaseForm extends BaseModel
{
	protected $scope;
	
	public $isNewRecord = false;
	
	public static function tableName()
	{
		return 'site_config';
	}
	

	public function loadModel()
	{
		$rows = Config::findAll(['scope'=>$this->scope]);
		
		foreach ($rows as $row)
		{
			$id = $row['id'];
			$this->$id= $row['value'];
		}
	}
	
	protected function saveItem($id, $value)
	{
		$exist = Config::findOne($id);
        $value = str_replace('\'', '‘', $value);
        $value = str_replace('\"', '“', $value);
		if($exist)
		{
			Config::updateAll(['value'=>$value],['id'=>$id]);
		}
		else
		{
			$model = new Model();
			$model->scope=$this->scope;
			$model->id=$id;
			$model->value=$value;
			$model->description=$id;
//            var_dump($model);die;
			$model->save();
		}		
	}


	public function save()
	{
		$attributes = $this->getAttributes();
		
		foreach ($attributes as $id=>$value)
		{
            $value = str_replace('\'', '‘',$value);
            $value = str_replace('\"', '“',$value);
			$this->saveItem($id, $value);
		}
		CacheUtility::createConfigCache();
	}
}
