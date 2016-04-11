<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<h3>
<?php if($msg){ 
        echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $msg,
        ]);
    }
?>

<div class="usuario-form col-md-4">

    <?php $form = ActiveForm::begin([
            'method' => 'post',
            'id'     => 'formulario',
        
          //  'enableClientValidation' => false,
         //   'enableAjaxValidation' => true,
    ]); ?>

 
    <?= $form->field($model, 'nombre1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido2')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'idtide')->dropDownList($tipo); ?>

    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, "clave")->input("password") ?> 
    <?= $form->field($model, "clave_repeat")->input("password") ?>  

     <?= $form->field($model, "email")->input("email") ?>   

    <?php echo $form->field($model, 'role')->dropDownList($role, ['prompt'=>'Seleccione...']); ?>
    <?php echo $form->field($model, 'idemp')->dropDownList($emp, ['prompt'=>'Seleccion...']); ?>
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
