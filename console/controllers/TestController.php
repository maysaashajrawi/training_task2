<?php 

namespace console\controllers;
use yii\console\Controller;
use backend\models\Post;
use backend\models\PostLifeCicle;
class TestController extends Controller 
{
    public function actionCheck(){
        $postLifeCycle = new PostLifeCicle();

        
        $word ="hello";
        $post = Post::find()->all();

        foreach($post as $field){

        $desc = $field->description;
        $title= $field->title;

        // Test if string contains the word 
        if(strpos($desc, $word) !== false || strpos($title, $word) !== false ){
            
            $post=Post::findOne($field->post_id);
            $old_Status = $post->status;
            $post->status="Block";
            $role = "system";
            $post_id = $field->post_id;
            $postLifeCycle->blockPost($post_id,$old_Status,$role);
            $post->save();

        } 
    }

    }
}

// to execute this program : php yii test/check 