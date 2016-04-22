<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Facturah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturah-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'idcli')->dropDownList($clientes); ?>

    <?= $form->field($model, 'refpago')->textInput(['maxlength' => true, 'readonly' => true]) ?>
   
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <!-- Facturad -->
    <table class="table table-striped  table-bordered table-showPageSummary">
        <tr>
            <th>Producto</th>
            <th>Valor</th>
            <th>Cant.</th>
            <th>Total Producto</th>
            <th class="action-column ">&nbsp;</th>
        </tr>
        <?php $totalant = 0; ?>
        <?php foreach($facturad as $row): ?>
          
          <tr>
            <th><?= $row->idpro0->nombre;?></th>
            <th><?= $row->valor; ?></th>
            <th><?= $row->qty;?></th>
            <th><?= $row->total;?></th>
            <th class="action-column ">&nbsp;</th>
          </tr>
               <?php $totalant = $totalant + $row->total; ?>  
        <?php endforeach; ?>  
        <tr>
            <td>
                <input type="hidden" name="totalant" id="totalant" value="<?= $totalant; ?>"></input>
                <?php echo $form->field($modelfd, 'idpro')->dropDownList($productos,
            ['prompt'=>'-Choose a Product-',
              'onchange'=>'
                $.get( "index.php?r=facturah/listprice&id="+$(this).val(), function( data ) {
                  $( "#facturad-valor" ).val( data );
                  $( "#facturad-vlr1" ).val( data );
                  $( "#facturad-neto" ).val( data );
                  $( "#facturad-total" ).val( data );
                  $total = parseInt(data) + parseInt($("#totalant").val());
                  $( "#facturah-total" ).val( $total );
                  $( "#faccredito-saldo" ).val($total);
                  $( "#faccredito-abono" ).val(0);

                });
            ']); 

            ?>
            </td>
            <td>
            <?= $form->field($modelfd, 'valor')->textInput(['maxlength' => true,
            'onchange'=>'
                  $totalfd = parseInt($(this).val());
                  $totalfh = $totalfd + parseInt($("#totalant").val());
                  $( "#facturad-total" ).val( $totalfd );
                  $( "#facturah-total" ).val( $totalfh);
                  $( "#faccredito-saldo" ).val($totalfh);
                  $( "#faccredito-abono" ).val(0);

            ']);  ?>

            <?= $form->field($modelfd, 'vlr1')->textInput(['maxlength' => true])->hiddenInput()->label(false);?>
            <?= $form->field($modelfd, 'neto')->textInput(['maxlength' => true])->hiddenInput()->label(false);?>
            </td>
            <td>
                <?= $form->field($modelfd, 'qty')->textInput(['maxlength' => true, 'value' =>1,
             'onchange'=>'
                $.get( "index.php?r=facturah/calprice&qty="+$(this).val()+"&vlr="+$("#facturad-valor").val(), function( data ) {
                 
                  $totalfd = data;
                  //Quede aqui.........XXXXXXXX  
                  $totalfh = parseInt($totalfd) + parseInt($("#totalant").val());
                  
                  $( "#facturad-total" ).val( data );
                  $( "#facturah-total" ).val( $totalfh);
                  $( "#faccredito-saldo" ).val($totalfh);
                  $( "#faccredito-abono" ).val(0);

                });
            ']); 

                 ?>
                </td>
            <td><?= $form->field($modelfd, 'total')->textInput(['readonly' => true]) ?></td>
            <td></td>
       </tr>
       <tr>
           <td colspan="3">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Agregar Producto' : 'Agregar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
           </td>
           <td colspan="2">
              <?= $form->field($model, 'total')->textInput(['readonly' => true]) ?>

              <?php echo $form->field($model, 'tipo')->dropDownList($tipo,
            [ 'onchange'=>'
                  $totalfh = $( "#facturah-total" ).val();
                  $("#faccredito-saldo").val($totalfh);
                  document.getElementById("credito").style.display = "block"; 
            ']); 
            ?>

              <div id="credito" name="credito" style="display: none;">
                <?= $form->field($modelcredito, 'abono')->textInput(['maxlength' => true, 
                                                                         'value' =>0,
                'onchange'=>'
                  $totalfh = $( "#facturah-total" ).val();
                  $vlrsaldo = $totalfh - parseInt ($(this).val());
                  $( "#faccredito-saldo" ).val($vlrsaldo);
                ']) ?>
                <?= $form->field($modelcredito, 'saldo')->textInput(['readonly' => true, 'value' => $totalant]) ?>
                
              </div>

              <?php if($model->tipo == "Credito"){ ?> 
                <script type="text/javascript">
                  document.getElementById("credito").style.display = "block"; 
                </script>
            <?php } ?>
            
           </td>
       </tr>
       </table>

    <?= Html::beginForm(Url::toRoute("facturah/updateend"), "POST") ?>
          <input type="hidden" name="idfh" value="<?= $model->idfh ?>">
          <input type="hidden" name="tipo" value="<?= $model->tipo ?>">
          <input type="hidden" name="abono" value="<?= $modelcredito->abono ?>">
                                    
          <button type="submit" class="btn btn-primary">Terminar</button>
    <?= Html::endForm() ?>
                          <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar Venta' : 'Agregar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
