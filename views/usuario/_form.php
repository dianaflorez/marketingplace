<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<h3><?= $msg; 
echo Alert::widget([
    'options' => [
        'class' => 'alert-info',
    ],
    'body' => 'Say hello...',
]);
?>

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

    <?= Html::activeDropDownList($model, 'idtide',$tipo) ?>

    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, "clave")->input("password") ?> 
    <?= $form->field($model, "clave_repeat")->input("password") ?>  

<div class="form-group">
 <?= $form->field($model, "email")->input("email") ?>   
</div>

  
    <?= Html::activeDropDownList($model, 'role',$role) ?>

    <?= Html::activeDropDownList($model, 'idemp',$emp) ?>

 
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
