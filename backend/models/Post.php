<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "post".
 *
 * @property int $post_id
 * @property int $category_id
 * @property int $country_id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property string $status
 * @property int $user_id
 *
 * @property Category $category
 * @property Country $country
 * @property User $user
 * @property Values[] $values
 */
class Post extends \yii\db\ActiveRecord
{


    const STATUS_BLOCK = 'block';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',  
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
 

    public function rules()
    {
        return [
            [['category_id', 'country_id', 'title', 'description', 'price', 'status', 'user_id'], 'required'],
            [['category_id', 'country_id', 'price', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'country_id']],
            // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'category_id' => 'Category ID',
            'country_id' => 'Country ID',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'status' => 'Status',
            // 'user_id' => Yii::$app->user->id,
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);

    }

    /**
     * Gets query for [[Values]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Values::className(), ['post_id' => 'post_id']);
    }

    public function newPost($cat_id){
        $new_post = new Post();
        $new_post->user_id =Yii::$app->user->id;
        $new_post->category_id =$cat_id;
        $new_post->country_id =$this->country_id;
        $new_post->title =$this->title;
        $new_post->description =$this->description;
        $new_post->price =$this->price;
        $new_post->status ='pending';
        if($new_post->save()){
           
            return $new_post->post_id;
        }
        return false;

        
    }
   
    public function userPosts($user_id){
        $post=$this->find()->where(['user_id'=>$user_id])->all();
        return $post;
      
    }

    public function getAllPosts(){
        $posts = new Post();
        $allPosts = $this->find()->all();
        return $allPosts;
    }

}


