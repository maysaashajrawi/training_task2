<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $category_id
 * @property string $category_name
 * @property int $parent
 *
 * @property FieldAssign[] $fieldAssigns
 * @property Post[] $posts
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name', 'parent'], 'required'],
            [['parent'], 'integer'],
            [['category_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'parent' => 'Parent',
        ];
    }

    /**
     * Gets query for [[FieldAssigns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFieldAssigns()
    {
        return $this->hasMany(FieldAssign::className(), ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'category_id']);
    }
}
