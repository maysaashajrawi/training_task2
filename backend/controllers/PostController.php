<?php

namespace backend\controllers;

use Yii;
use backend\models\Post;
use backend\models\Field_assign;
use backend\models\Options;
use backend\models\SearchPost;
use backend\models\Values;
use backend\models\PostLifeCicle;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPost();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $field_model = new Field_assign();
        $fields = $field_model->getAllFields();

        $option_model = new Options();
        $options = $option_model->getAllOptions();

        $model = new Post();
        $value_model = new Values();

        $postLifeCycle = new PostLifeCicle;
        
         
        if ($model->load(Yii::$app->request->post()) ) {
            $cat = $_POST["category_id"];
            $post_id =  $model->newPost($cat);
            $postLifeCycle->savePostLifeCycle($post_id);
            
           
            if((bool)$post_id){
                // iterate throught data come from create post to get field and option values to save them in values table
                foreach (Yii::$app->request->post() as $key => $value) {
                  
                    if (strpos($key, 'field') !==  false) {
                        $field_id = (int)(substr($key, 6));
                        $option_id =(int)$value;
                        $value_model->saveValues($post_id,$field_id,$option_id);
                    }     
                }    
   
                // return $this->redirect(['view', 'id' => $model->post_id]);
                return $this->redirect(['post/posts']);

            }
            
            else{
                echo '<h1>error</h1>';
                die();
            }

            // return $this->redirect(['user/index']);
        }
       

        return $this->render('create', [
            'model' => $model,
            'fields'=>$fields,
            'options'=>$options
        ]);


        
    }


    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionPosts()
    {
        $post= new Post();
        $postGet=$post->userPosts(Yii::$app->user->id);
        $pages = count($postGet)/3;

        // $model=Post::find()->where(['user_id'=>Yii::$app->user->id])->all();
        return $this->render('posts',[
            'post'=>$postGet,
            'pages'=>$pages,
        ]);

       
    }

    public function actionGetposts(){
        
        $post = new Post();
        $postGet=$post->userPosts(Yii::$app->user->id);
        $per_page_record = 3;
        $pages = count($postGet)/3;
        $model=Post::find()->where(['user_id'=>Yii::$app->user->id])->orderBy([
            'post_id' => SORT_ASC //specify sort order ASC for ascending DESC for descending      
            ])->limit(3)->all();
        


        return $this->render('posts',[
            'post'=>$model,
            'pages'=>$pages,
        ]);



    }


    public function actionDeletepost($post_id)
    {
        $this->findModel($post_id)->delete();

        return $this->redirect(['posts']);
    }



    public function actionAll(){
        $model = new Post();
        $allPosts=$model->getAllPosts();
        
        return $this->render('allPosts',[
            'posts'=>$allPosts
        ]);
    }



    public function actionAccept($post_id)
    {
       $post=Post::findOne($post_id);
       $oldStatus=$post->status;
       $post->status="live";

       $post->save();
       $postLifeCycle= new PostLifeCicle();
       $postLifeCycle->LivePost($post_id,$oldStatus);
       return $this->redirect(['all']);
    }

    public function actionBlock($post_id)
    {
       $post=Post::findOne($post_id);
       $oldStatus = $post->status;
       $post->status="Block";
       $role = "admin";
       $post->save();
       $postLifeCycle= new PostLifeCicle();
       $postLifeCycle->blockPost($post_id,$oldStatus,$role);

        return $this->redirect(['all']);

    }


    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    
}
