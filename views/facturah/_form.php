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
    <table class="table table-striped  table-bordered table-showPageSummary">
        <tr>
            <th>Producto</th>
            <th>Valor</th>
            <th>Cant.</th>
            <th>Total</th>
            <th class="action-column ">&nbsp;</th>
        </tr>
        <?php //foreach($model as $row): ?>
        <tr>
            <td>


                <?php echo $form->field($modelfd, 'idpro')->dropDownList($productos,
['prompt'=>'-Choose a Product-',
              'onchange'=>'
                $.get( "index.php?r=facturah/listprice&id="+$(this).val(), function( data ) {
                  $( "#total" ).val( data );
                });
            ']); 

            ?>

            <input type="text" name="total" id="total" value="0"></input>
                <?php // $row->idemp ?>

            </td>
            <td><?= $form->field($modelfd, 'neto')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($modelfd, 'qty')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($modelfd, 'total')->textInput(['maxlength' => true]) ?></td>
            <td></td>
       </tr>
       </table>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nueva' : 'Agregar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
