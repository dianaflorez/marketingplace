<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>

<div class="cliente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($cliente == "Institucional") {?>
        <?= $form->field($model, 'nit')->textInput(['maxlength' => true]) ?>
    <?php } ?>    
    
    <?= $form->field($model, 'nombre1')->textInput(['maxlength' => true]) ?>

    <?php if($tipo != "Institucional" ){?>
        <?php // $form->field($model, 'nombre2')->textInput(['maxlength' => true]) ?>
            
        <?= $form->field($model, 'apellido1')->textInput(['maxlength' => true]) ?>

        <?php // $form->field($model, 'apellido2')->textInput(['maxlength' => true]) ?>

        <?php if($tipo != "Esporadico" ){?>

            <?php echo $form->field($model, 'idtide')->dropDownList($tide); ?>

            <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
   
            <?php
            echo $form->field($model, 'fecnac')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Ingrese Fecha de Nacimiento ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-m-dd'
                ]
            ]);
            ?>

            <?php echo $form->field($model, 'genero')->dropDownList($genero); ?>
        <?php } ?>
    <?php } ?>
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'estado')->dropDownList($estado); ?>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nuevo' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
