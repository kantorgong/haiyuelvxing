<?php
/**
 * 数据字典模型
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/25 20:48
 * @since    1.0
 */

namespace common\models;


use Yii;
use components\db\BaseActiveRecord;
use components\helper\CacheUtility;
/**
 * This is the model class for table "yii_dict".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $value
 * @property string $category_id
 * @property integer $sort_num
 */
class Dict extends BaseActiveRecord
{
    private $defaultSort = 'sort_num asc';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_dict';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'category_id', 'name', 'value'], 'required'],
            [['name'], 'unique'],
            [['parent_id', 'sort_num'], 'integer'],
            [['category_id', 'name'], 'string', 'max' => 64],
            [['value'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'parent_id' => '父级',
            'name' => '名称',
            'value' => '值',
            'category_id' => '分类Key',
            'sort_num' => '排序'];
    }

    private $_level;

    public function getLevel()
    {
        return $this->_level;
    }

    public function setLevel($value)
    {
        $this->_level = $value;
    }

    //检查重复value
    public function checkExist()
    {
        if ($this->isNewRecord || $this->value != $this->oldAttributes['value'])
        {
            $ret = Dict::findOne(['category_id' => $this->category_id, 'value' => $this->value]);
            return $ret !== null;
        }
        return false;
    }

    public static function getParents($id, $fromCache = true)
    {
        $ret = [];

        $current = Dict::findOne(['id' => $id]);
        if ($current === null)
        {
            return $ret;
        }
        array_unshift($ret, $current);

        $parent = Dict::findOne(['id' => $current['parent_id']]);
        while ($parent != null)
        {
            array_unshift($ret, $parent);

            $parent = Dict::findOne(['id' => $parent['parent_id']]);
        }

        return $ret;
    }

    public static function getChildren($categoryId, $id)
    {
        return Dict::findAll(['category_id' => $categoryId, 'parent_id' => $id], 'sort_num asc');
    }

    public static function getChildrenIds($id)
    {
        $ret = [];

        $children = Dict::findAll(['parent_id' => $id], 'sort_num asc');
        foreach ($children as $child)
        {
            $ret[] = $child['id'];
        }
        return $ret;
    }

    public static function _getDictArrayTree($categoryId, $parentId = 0, $level = 0)
    {
        $ret = [];

        $dataList = Dict::findAll(['category_id' => $categoryId, 'parent_id' => $parentId], 'sort_num DESC, id DESC');

        if ($dataList == null || empty($dataList))
        {
            return $ret;
        }

        foreach ($dataList as $key => $value)
        {
            $value->level = $level;
            $ret[] = $value;

            $temp = self::_getDictArrayTree($categoryId, $value['id'], $level + 1);
            $ret = array_merge($ret, $temp);
        }
        return $ret;
    }

    public function afterSave($insert = Null, $changedAttributes = NULL)
    {
        //刷新缓存
        CacheUtility::createDictCache();
    }
}
