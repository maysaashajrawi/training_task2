<?php
 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;
use backend\models\Country;
/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="post-form">
    

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(Category::find()->where(["parent" => 0])->all(),"category_id","category_name"),
        ["prompt" => "select Category"]
    ) ?>

    
    <!-- <?= $form->field($model, 'country_id')->dropDownList(
        ArrayHelper::map(Country::find()->all(),"country_id","country_name"),
        ["prompt" => "select Country"]
    ) ?> -->

 

  
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
