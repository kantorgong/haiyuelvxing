<?php
/**
 * 数据字典分类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/25 20:52
 * @since    1.0
 */

namespace common\models;


use Yii;
use components\db\BaseActiveRecord;
use components\helper\CacheUtility;

/**
 * This is the model class for table "yii_dict_category".
 *
 * @property string $id
 * @property string $name
 * @property boolean $is_sys
 * @property string $note
 */
class DictCategory extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_dict_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'unique'],
            [['is_sys'], 'boolean'],
            [['id', 'name'], 'string', 'max' => 64],
            [['note'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '缓存Key',
            'name' => '名称',
            'is_sys' => '是否系统',
            'note' => '备注',
        ];
    }

    public function checkExist()
    {
        if ($this->isNewRecord || $this->id != $this->oldAttributes['id'])
        {
            $ret = DictCategory::findOne($this->id);
            return $ret !== null;
        }
        return false;
    }

    /**
     * 获取数据字典分类
     *
     *
     * @param $id
     * @return array
     *
     * @author     gongjt@xxcb.cn
     * @since      1.0
     */
    public static function getDictCategory($id)
    {
        if ($id != '')
        {
            return DictCategory::findOne($id);
        }
    }

    public function afterSave($insert = Null, $changedAttributes = NULL)
    {
        //刷新缓存
        CacheUtility::createDictCache();
    }
}
