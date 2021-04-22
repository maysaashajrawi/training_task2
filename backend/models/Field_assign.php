<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "field_assign".
 *
 * @property int $field_assign_id
 * @property int $field_id
 * @property int $category_id
 * @property int $country_id
 * @property string $label
 *
 * @property Category $category
 * @property Country $country
 * @property Fields $field
 * @property Options[] $options
 */
class Field_assign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'field_assign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'category_id', 'country_id', 'label'], 'required'],
            [['field_id', 'category_id', 'country_id'], 'integer'],
            [['label'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'country_id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fields::className(), 'targetAttribute' => ['field_id' => 'field_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'field_assign_id' => 'Field Assign ID',
            'field_id' => 'Field ID',
            'category_id' => 'Category ID',
            'country_id' => 'Country ID',
            'label' => 'Label',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
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
    public function getAllFields(){
        
        // echo "<pre>";
        // var_dump(Yii::$app->user->country_id);
        // die();
        return $this->find()->where(["country_id"=>Yii::$app->user->identity->country_id])->all();
        
    }

    /**
     * Gets query for [[Options]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Options::className(), ['field_assign_id' => 'field_assign_id']);
    }
}
