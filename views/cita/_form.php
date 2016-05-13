<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

//Para autocomplete
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Cita */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cita-form">

    <?php $form = ActiveForm::begin(); ?>

      <label class="control-label">Buscar Cliente</label>
        <br />
        <?php
        echo AutoComplete::widget([    
        'class'=>'form-control',
        'clientOptions' => [
        'class'=>'form-control',
        'source'    => $data,
        'minLength' => '3', 
        'autoFill'  => true,
        'select'    => new JsExpression("function( event, ui ) {
                        $('#cliente_id').val(ui.item.id);//#cliente_id is the id of hiddenInput.
                        $('#nombre_id').val(ui.item.value);
                        $('#cita-idcli').val( ui.item.id );
                     }")],
                     ]);
                ?>
        <input type="hidden" name="cliente_id" id="cliente_id" />
        <b><input type="text" name="nombre_id" id="nombre_id" style="border-width:0;" readonly />
        </b>
         <?php echo $form->field($model, 'idcli')->hiddenInput()->label(false);?>


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

    <?php echo $form->field($model, 'estado')->dropDownList($estado); ?>
   
    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nueva' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
