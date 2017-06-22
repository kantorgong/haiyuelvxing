<?php
/**
 * UploadForm
 * 作者: limj
 * 版本: 17-1-13
 */

namespace common\models\form;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $image;
    public $voice;
    public $file;

    /**
     * 图片规则验证demo
     */
    public function rules()
    {
        return [
            [['image'], 'file',
                // 需要安装一个php扩展才能检测;
//                'extensions' => ['png', 'jpg', 'gif'],'wrongExtension'=>'只能上传{extensions}类型文件！',
                // skipOnEmpty检测是否准许为空,为true准许为空，false不准许为空
                'skipOnEmpty'=>false,'uploadRequired'=>'图片不能为空',
                'maxSize'=>1024*1024*5,'tooBig'=>'文件上传过大！',
            ],
            [['voice'], 'file',
                'skipOnEmpty'=>false,'uploadRequired'=>'语音不能为空',
                'maxSize'=>1024*1024*5,'tooBig'=>'文件上传过大！',
            ],
        ];
    }
        public function scenarios()
        {
            return [
            'images' => ['image'],
            'voices' => ['voice'],
            ];
        }
    public function attributeLabels()
    {
        return ['image'=>'图片上传',
                'voice'=>'语音上传',
        ];
    }
}