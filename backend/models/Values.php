<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "values".
 *
 * @property int $value_id
 * @property int $post_id
 * @property int $field_id
 * @property int $option_value_id
 * @property int $value_int
 * @property string $value_varchar
 * @property float $value_double
 *
 * @property Fields $field
 * @property Options $optionValue
 * @property Post $post
 */
class Values extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value_id', 'post_id', 'field_id', 'option_value_id'], 'required'],
            [['value_id', 'post_id', 'field_id', 'option_value_id', ], 'integer'],
            // [['value_double'], 'number'],
            // [['value_varchar'], 'string', 'max' => 100],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fields::className(), 'targetAttribute' => ['field_id' => 'field_id']],
            [['option_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => Options::className(), 'targetAttribute' => ['option_value_id' => 'option_id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'post_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'value_id' => 'Value ID',
            'post_id' => 'Post ID',
            'field_id' => 'Field ID',
            'option_value_id' => 'Option Value ID',
            // 'value_int' => 'Value Int',
            // 'value_varchar' => 'Value Varchar',
            // 'value_double' => 'Value Double',
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
     * Gets query for [[OptionValue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOptionValue()
    {
        return $this->hasOne(Options::className(), ['option_id' => 'option_value_id']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['post_id' => 'post_id']);
    }
    public function saveValues($post_id,$field_id,$option_id){
    
        $values = new Values();
        echo ($post_id."<br>");

        $values->post_id = $post_id;
      
        $values->field_id = $field_id;
        
        $values->option_value_id = $option_id;
        $sql = "INSERT INTO `values`(`post_id`, `field_id`, `option_value_id`) VALUES ($post_id, $field_id, $option_id)";
        Yii::$app->db->createCommand($sql)->execute();
        // print_r (gettype($values->post_id));
        // die();
        
        // $values->save();
        return true;
   
        

    }
}
