<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use yii\bootstrap\Tabs;


//IMPORTANTE Sin esto no funciona el menu del logo 
Tabs::widget(); 
//FIN

?>

<div class="planaccion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'responsable')->textInput() ?>

    <?= $form->field($model, 'costo')->textInput() ?>

    <?php echo $form->field($model, 'estado')->dropDownList($estado); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nuevo' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php  //IMPORTANTE Sin esto no funciona el menu del logo 
    Tabs::widget(); 
?>
