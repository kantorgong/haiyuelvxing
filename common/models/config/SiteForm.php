<?php

namespace common\models\config;

use Yii;
use yii\base\Model;
use components\db\BaseModel;
use components\helper\CacheUtility;

/**
 * LoginForm is the model behind the login form.
 */
class SiteForm extends BaseForm
{
	protected $scope="site";
	
	public $site_name;	
	public $site_url;
	public $site_path;
	public $site_logo;
	public $site_icp;
	public $site_copyright;
	public $site_stats;
	public $site_status;
	public $site_status_message;
	public $site_admin_email;
    public $seo_title;
    public $seo_keywords;
    public $seo_description;
	
	
	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			['site_status', 'boolean'],
            [['seo_title', 'seo_keywords'], 'string'],
            ['seo_description', 'string'],
			[['site_name', 'site_url', 'site_path', 'site_logo', 'site_icp', 'site_copyright', 'site_stats', 'site_status_message', 'site_admin_email'],'string'],
		];
	}


	public function attributeLabels()
	{
		return [
			'site_name' => '站点名称',
			'site_url' => '站点Url',
			'site_path' => '站点路径',
			'site_logo' => 'Logo路径',
			'site_admin_email' => '管理员邮箱',
			'site_icp' => '备案号',
			'site_copyright' => '版权信息',
			'site_stats' => '统计代码',
			'site_status' => '站点状态',
			'site_status_message' => '关闭消息',
            'seo_title' => 'SEO 标题',
            'seo_keywords' => 'SEO 关键字',
            'seo_description' => 'SEO 描述',
		];
	}
}
