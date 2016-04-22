<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Cita */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cita-form">

    <?php $form = ActiveForm::begin(); ?>

  
    <?= $form->field($model, 'idcli')->textInput() ?>

    <?php
    echo $form->field($model, 'fecha')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ingrese Fecha de Inicio ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-m-dd'
        ]
    ]);
    ?>

    <?= $form->field($model, 'hora')->textInput() ?>

    <?php
    echo $form->field($model, 'hora')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ingrese hora ...'],
    
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'hh:mm:ss a'
        ]
    ]);
    ?>



<?php /*
    echo '<label class="control-label">Set Time</label>';
echo DateTimePicker::widget([
    'name' => 'datetime_400',
    'value' => '01/04/2005 08:17',
    'removeButton' => false,
    'pickerButton' => ['icon' => 'time'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'mm/dd/yyyy hh:ii'
    ]
]);*/
?>
    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'feccre')->textInput() ?>

    <?= $form->field($model, 'fecmod')->textInput() ?>

    <?= $form->field($model, 'usumod')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
