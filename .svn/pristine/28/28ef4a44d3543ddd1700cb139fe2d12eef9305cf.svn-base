<?php
/**
 * 上传类
 *
 * 返回文件地址
 * @author   gongjt@xxcb.cn
 * @version  2016/3/18 14:33
 * @since    1.0
 */

namespace components\helper;


use yii;
use yii\base\Object;
use yii\web\UploadedFile;
use components\helper\CommonUtility;
use components\XyXy;

class Upload extends Object
{
    /**
     * [UploadPhoto description]
     * @param [type]  $model      [实例化模型]
     * @param [type]  $path       [图片存储路径]
     * @param [type]  $originName [图片源名称]
     * @param boolean $isthumb [是否要缩略图]
     */
    public function UploadPhoto($model, $path, $originName, $isthumb = false)
    {
        $root = dirname(dirname(__DIR__)) . '/frontend/web/' . $path;
        //返回一个实例化对象
        $files = UploadedFile::getInstance($model, $originName);
        $folder = date('Ym') . "/";

        $pre = date('His') . strtolower(CommonUtility::random(16)) . strrchr($_FILES['imgFile']['name'], '.');
        if ($files && ($files->type == "image/jpg" || $files->type == "image/jpeg" || $files->type == "image/pjpeg" || $files->type == "image/png" || $files->type == "image/x-png" || $files->type == "image/gif"))
        {
            $newName = $pre . '.' . $files->getExtension();
        }
        else
        {
            $result['status'] = 1;
            $result['message'] = "文件格式不支持";
            return $result;
        }

        //系统预设上传文件大小
        $cms_uploadfile_max = CommonUtility::getVariableValue('cms_uploadfile_max');

        $size = $_FILES['imgFile']['size'];
        if ($files->size > $cms_uploadfile_max)
        {
            $result['status'] = 1;
            $result['message'] = "上传的文件太大";
            return $result;
        }


        if (!is_dir($root . $folder))
        {
            if (!mkdir($root . $folder, 0777, true))
            {
                $result['status'] = 1;
                $result['message'] = "创建目录失败";
                return $result;
            }
            else
            {
                chmod($root . $folder, 0777);
            }
        }

        //echo $root.$folder.$newName;exit;
        if ($files->saveAs($root . $folder . $newName))
        {
//            if ($isthumb)
//            {
//                $this->thumbphoto($files, $path . $folder . $newName, $path . $folder . 'thumb' . $newName);
//
//                return XyXy::getFrontendWebUrl() . $path . $folder . $newName . '#' . $path . $folder . 'thumb' . $newName;
//            }
//            else
//            {
                    $result['status'] = 200;
                    $result['message'] = "上传成功";
                    $result['url'] = XyXy::getFrontendWebUrl() . $path . $folder . $newName;
                    return $result;
//            }

        }
    }
}