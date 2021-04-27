<?php

namespace common\models;

use Yii;

/**
 * This is the model class for collection "Posts".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $user_id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $price
 * @property mixed $status
 * @property mixed $category
 * @property mixed $post_id
 * @property mixed $country
 * @property mixed $custom_params
 */
class Posts extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['open_sooq', 'Posts'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'user_id',
            'title',
            'description',
            'price',
            'status',
            'category',
            'post_id',
            'country',
            'custom_params',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'description', 'price', 'status', 'category', 'post_id', 'country', 'custom_params'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'status' => 'Status',
            'category' => 'Category',
            'post_id' => 'Post ID',
            'country' => 'Country',
            'custom_params' => 'Custom Params',
        ];
    }
}
