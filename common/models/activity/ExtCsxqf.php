<?php

namespace common\models\activity;

use Yii;

/**
 * This is the model class for table "ext_csxqf".
 *
 * @property integer $id
 * @property string $area
 * @property string $school
 * @property string $extent
 * @property string $remark
 */
class ExtCsxqf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ext_csxqf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area', 'school', 'extent'], 'required'],
            [['extent','remark'], 'string'],
            [['area', 'school',], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => 'Area',
            'school' => 'School',
            'extent' => 'Extent',
            'remark' => 'Remark',
        ];
    }
}
