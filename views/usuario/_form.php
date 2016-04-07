<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<h3><?= $msg ?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin([
            'method' => 'post',
            'id' => 'formulario',
          //  'enableClientValidation' => false,
         //   'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($model, 'nombre1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idtide')->textInput() ?>

    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, "clave")->input("password") ?> 
    <?= $form->field($model, "clave_repeat")->input("password") ?>  

<div class="form-group">
 <?= $form->field($model, "email")->input("email") ?>   
</div>

  
    <?= $form->field($model, 'role')->textInput() ?>

  
    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idemp')->textInput() ?>

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
