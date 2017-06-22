<?php

namespace backend\modules\service\controllers;

use Yii;
use components\XyXy;
use yii\helpers\Json;
use components\helper\UploadFile;
use components\helper\CommonUtility;

class UploadController extends \backend\modules\service\components\Controller
{
    public $enableCsrfValidation = false;

    private $_thumbMaxSize = 71680;  //50KB

    private $_thumbMaxWidth = '800'; //压缩的最大宽度

    private $_thumbMaxHeight = '600'; //压缩的最大高度

    /**
     * @Desc: 上传文件的字段名称为file
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionImage()
    {
        if(!empty($_FILES))
        {
            $config = Yii::$app->request->post();
            !$config && $config = [];

            //设置最大上传值
            !isset($config['maxSize']) && $config['maxSize'] = CommonUtility::getVariableValue('cms_uploadfile_max');

            //设置可上传图片类型
            !isset($config['allowExts']) && $config['allowExts'] = array('jpg', 'gif', 'png', 'jpeg');

            //设置上传路径
            $upload_dir = Yii::getAlias('@upload');
            if (!isset($config['savePath']))
            {
                $savePath = $config['savePath'] = 'cwds/' . date('Ym') . '/';
            }
            else
            {
                $savePath = $config['savePath'];
            }
            $config['savePath'] = $upload_dir . '/' . $config['savePath'];

            //内容上传图片为imgFile
            $_FILES['file'] = $_FILES['file'] ? $_FILES['file'] : $_FILES['imgFile'];
            
            //所有图片超过50KB统一进行压缩处理，修改最大高度和宽度压缩率更高
            if ($_FILES['file']['size'] > $this->_thumbMaxSize)
            {
                $config['thumb']             = true;                    // 使用对上传图片进行缩略图处理
                $config['thumbMaxWidth']     = $this->_thumbMaxWidth;   // 缩略图最大宽度
                $config['thumbMaxHeight']    = $this->_thumbMaxHeight;  // 缩略图最大高度
                $config['thumbPrefix']       = '';                      // 缩略图前缀
            }

            $upload = new UploadFile($config);
            
            $info = $upload->uploadOne($_FILES['file']);
            if(!$info)
            {
                echo Json::encode(['error' => 1, 'message' => $upload->getErrorMsg()?:'上传失败']);
            }
            else
            {
                $url = XyXy::getUploadWebUrl() . $savePath . $info[0]['savename'];
                echo Json::encode(['error' => 0, 'url' => $url]);
            }
        }
        else
        {
            echo Json::encode(['error' => 1, 'message' => Yii::t('app', "上传失败")]);
        }
        Yii::$app->end();
    }

    /**
     * @Desc: 删除文件/图片
     * @User: zhujw <zhjw@xxcb.cn>
     */
    public function actionDelete()
    {
        $url = Yii::$app->request->post('url');

        if (!$url) exit(Json::encode(['error' => 1, 'message' => '参数错误']));

        if (strpos($url, 'f2.teencn.') == false) exit(Json::encode(['error' => 1, 'message' => '没有权限']));

        $upload_dir = Yii::getAlias('@upload');

        $uploadWebUrl = XyXy::getUploadWebUrl();

        $file = $upload_dir . '/' . str_replace($uploadWebUrl, '', $url);

        if (!file_exists($file)) exit(Json::encode(['error' => 1, 'message' => '文件不存在']));

        @unlink($file);

        echo Json::encode(['error' => 0]);
        Yii::$app->end();
    }
}
