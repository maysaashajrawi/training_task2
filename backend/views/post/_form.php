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
    
       
    
    
    
    <?= $form->field($model, 'country_id')->dropDownList(
        ArrayHelper::map(Country::find()->all(),"country_id","country_name"),
        ["prompt" => "select Country"]
    ) ?>
    

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div id="new-attr"></div>
  
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<div class="modal fade" id="exampleModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select a category</h5>
        </button>
      </div>
      <div class="modal-body">
        <form id="cat-form">
            
            <?= $form->field($model, 'category_id')->dropDownList(
                ArrayHelper::map(Category::find()->where(["parent" => 0])->all(),"category_id","category_name"),
                ["id"=>"cat_id" ]
            ) ?>
           
        </form>
      </div>
    <div class="modal-footer">
        <button type="button" id="cat-select" class="btn btn-primary">Select</button>
    </div>
    </div>
  </div>
</div>

<?php

  $this->registerJs(
     " 
     var selected_cat =1;
     var fields = $fields;
     var options = $options;
        $(window).on('load', function() {
            $('#exampleModal').modal('show');
        })
        $('#exampleModal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#cat-select').on('click', function(){
            selected_cat = $('#cat_id').val();
            $('#new-attr').append(`<input type ='hidden' value=`+selected_cat+` name='category_id' />`);
            $('#exampleModal').modal('hide');
            for(var i = 0;i<fields.length;i++){
                let obj =fields[i];
                if(selected_cat == obj.category_id){
                    let html= `<label>`+obj.label+`</label>
                               <select name = field_`+obj.field_id+` class='form-control mb-4'>`;
                    for(let j=0;j<options.length;j++){
                        let optionObj = options[j];
                        if(optionObj.field_id == obj.field_id){
                            html += `<option value= `+optionObj.option_id+`>`+optionObj.option_name+`</option>`;
                        }


                    }
                    html +=`</select>`;

                    





                    $('#new-attr').append(html)
                }
    
    
            }
            
        });
        
       


"

);



?>