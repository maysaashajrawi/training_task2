<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property int $option_id
 * @property string $option_name
 * @property int $field_id
 * @property int $field_assign_id
 *
 * @property Fields $field
 * @property FieldAssign $fieldAssign
 * @property Values[] $values
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_name', 'field_id', 'field_assign_id'], 'required'],
            [['field_id', 'field_assign_id'], 'integer'],
            [['option_name'], 'string', 'max' => 100],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fields::className(), 'targetAttribute' => ['field_id' => 'field_id']],
            [['field_assign_id'], 'exist', 'skipOnError' => true, 'targetClass' => FieldAssign::className(), 'targetAttribute' => ['field_assign_id' => 'field_assign_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'option_id' => 'Option ID',
            'option_name' => 'Option Name',
            'field_id' => 'Field ID',
            'field_assign_id' => 'Field Assign ID',
        ];
    }

    /**
     * Gets query for [[Field]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Fields::className(), ['field_id' => 'field_id']);
    }

    /**
     * Gets query for [[FieldAssign]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFieldAssign()
    {
        return $this->hasOne(FieldAssign::className(), ['field_assign_id' => 'field_assign_id']);
    }

    /**
     * Gets query for [[Values]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Values::className(), ['option_value_id' => 'option_id']);
    }
    public function getAllOptions(){
        return $this->find()->all();
    }
}
