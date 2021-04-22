<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "fields".
 *
 * @property int $field_id
 * @property string $field_name
 *
 * @property FieldAssign[] $fieldAssigns
 * @property Options[] $options
 * @property Values[] $values
 */
class Fields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_name'], 'required'],
            [['field_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'field_id' => 'Field ID',
            'field_name' => 'Field Name',
        ];
    }

    /**
     * Gets query for [[FieldAssigns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFieldAssigns()
    {
        return $this->hasMany(FieldAssign::className(), ['field_id' => 'field_id']);
    }

    /**
     * Gets query for [[Options]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Options::className(), ['field_id' => 'field_id']);
    }

    /**
     * Gets query for [[Values]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Values::className(), ['field_id' => 'field_id']);
    }
}
