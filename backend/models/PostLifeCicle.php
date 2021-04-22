<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "post_life_cicle".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $post_id
 * @property mixed $current_status
 * @property mixed $previous_status
 * @property mixed $role
 * @property mixed $date_inserted
 * @property mixed $time_between_two_status
 */
class PostLifeCicle extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['open_sooq', 'post_life_cicle'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'post_id',
            'current_status',
            'previous_status',
            'role',
            'date_inserted'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'current_status', 'previous_status', 'role', 'date_inserted'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'post_id' => 'Post ID',
            'current_status' => 'Current Status',
            'previous_status' => 'Previous Status',
            'role' => 'Role',
            'date_inserted' => 'Date Inserted'
        ];
    }
    public function savePostLifeCycle($postId){
        $newPost = new PostLifeCicle();
        $newPost->post_id = $postId;
        $newPost->current_status = 'pending';
        $newPost->previous_status = null;
        $newPost->role = 'owner';
        $newPost->save();
    } 
    public function blockPost($postId,$previous_status,$role){
        $newPost = new PostLifeCicle();
        $newPost->post_id = $postId;
        $newPost->current_status = 'Block';
        $newPost->previous_status = $previous_status;
        $newPost->role = $role;
        $newPost->date_inserted = date('Y/m/d');
        $newPost->save();
    }
    public function LivePost($postId,$previous_status){
        $newPost = new PostLifeCicle();
        $newPost->post_id = $postId;
        $newPost->current_status = 'Live';
        $newPost->previous_status = $previous_status;
        $newPost->role = 'admin';
        $newPost->date_inserted = date('Y/m/d');
        $newPost->save();
    }  


}
