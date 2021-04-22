<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $country_id
 * @property string $country_name
 *
 * @property FieldAssign[] $fieldAssigns
 * @property Post[] $posts
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_name'], 'required'],
            [['country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'country_id' => 'Country ID',
            'country_name' => 'Country Name',
        ];
    }

    /**
     * Gets query for [[FieldAssigns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFieldAssigns()
    {
        return $this->hasMany(FieldAssign::className(), ['country_id' => 'country_id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['country_id' => 'country_id']);
    }
}
