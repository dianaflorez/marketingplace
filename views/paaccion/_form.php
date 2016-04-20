<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Paaccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paaccion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

   <?php
    echo $form->field($model, 'fecini')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ingrese Fecha de Inicio ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-m-dd'
        ]
    ]);
    ?>

    <?php
    echo $form->field($model, 'fecfin')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ingrese Fecha Finalizacion ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-m-dd'
        ]
    ]);
    ?>

    <?= $form->field($model, 'responsable')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'costo')->textInput() ?>

    <?php echo $form->field($model, 'estado')->dropDownList($estado); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nuevo' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
