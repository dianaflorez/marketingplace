<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Faccredito */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faccredito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php setlocale(LC_MONETARY, 'en_US.UTF-8');
        $pago = money_format('%.2n', $model->totalfh); ?>
       <b><?= "Total Pago = ".$pago ?></b>
    <br />   
    <?php setlocale(LC_MONETARY, 'en_US.UTF-8');
        $abonoantm = money_format('%.2n', $abonoant); ?>
       <b><?= "Abonos realizados = ".$abonoantm ?></b>

    <input type="hidden" name="total" value="<?= $model->totalfh ?>"/>   
    <input type="hidden" name="saldo" value="<?= $model->saldo ?>"/>   
    <input type="hidden" name="abono" value="<?= $abonoant ?>"/>
       
    <?= $form->field($model, 'abono')->textInput(['maxlength' => true, 
                                                      'value' =>0,
                'onchange'=>'

                  if( isNaN( $(this).val() ) ) {
                    $(this).val(0);
                  }

                  $totalfh = parseInt( $( "#total" ).val());
                  $abono   = parseInt( $(this).val());
                  $saldo   = parseInt( $(saldo).val())

                  if($abono > $saldo){
                    $(this).val(0) ;
                    $abono = 0;
                  }

                  $vlrsaldo = $saldo - $abono;

                  $( "#faccredito-saldo" ).val($vlrsaldo);
                  
    ']) ?>

    <?= $form->field($model, 'saldo')->textInput(['readonly' => true]) ?>

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar Abono' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
