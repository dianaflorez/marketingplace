<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Cita */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cita-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'idcli')->dropDownList($clientes); ?>
  
    <?php
    echo $form->field($model, 'fecha')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ingrese Fecha de Inicio ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-m-dd'
        ]
    ]);
    ?>

<?php echo $form->field($model, 'hora')->widget(TimePicker::classname(), [

    'name' => 'start_time', 
        'value' => '08:24 AM',
        'pluginOptions' => [
            'showSeconds' => true

        ]
]); ?>


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
    <?php echo $form->field($model, 'estado')->dropDownList($estado); ?>
   
    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nueva' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
