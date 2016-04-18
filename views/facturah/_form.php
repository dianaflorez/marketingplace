<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Facturah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturah-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'idcli')->dropDownList($clientes); ?>

    <?= $form->field($model, 'refpago')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <!-- Facturad -->
    <?php echo $form->field($modelfd, 'idpro')->dropDownList($productos); ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nueva' : 'Agregar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
