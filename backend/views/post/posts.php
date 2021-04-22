<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchPost */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
<!-- 
    <p>
        <?= Html::button('Create Post', ['value'=>Url::to('post/popup'),'class' => 'btn btn-success','id'=>'modalButton']) ?>
    </p> -->



   <?php
 foreach($post as $value)
 {?>

<div class="card">

  <div class="card-header">
    <?= $value->title ?>
  </div>
  <hr/>
  <div class="card-body">
    
    <p class="card-text">Description: <?= $value->description ?></p>
    <p class="card-text">Price:<?= $value->price ?></p>
    <p class="card-text">status: <span><?= $value->status ?><span></p>
    <?php 
      $len = count($value->values);
      for ($i = 0; $i < $len; $i++) { 
      ?>
      <p class="card-text"><?= $value->values[$i]->field->field_name ?> : <?= $value->values[$i]->optionValue->option_name ?></p>
      <?php
      }
      ?>
       <hr/>
    <?= Html::a('Delete', ['deletepost', 'post_id' => $value->post_id], ['class' => 'btn btn-danger']) ?>
    <hr/>
  </div>
</div>
<hr/>
  
 <?php }

?>
  