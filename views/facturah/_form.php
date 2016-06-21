<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

//Para autocomplete
use yii\jui\AutoComplete;
use yii\web\JsExpression;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN
?>

<div class="facturah-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo '<b>Buscar Cliente</b>' .'<br>';
    echo AutoComplete::widget([    
    'class'=>'form-control',
    'clientOptions' => [
  'class'=>'form-control',
    'source'    => $data,
    'minLength' => '3', 
    'autoFill'  => true,
    'select'    => new JsExpression("function( event, ui ) {
                    $('#facturah-idcli').val(ui.item.id);//#cliente_id is the id of hiddenInput.
                    $('#nombre_id').val(ui.item.value);
                 }")],
                 ]);
            ?>
    <input type="hidden" name="cliente_id" id="cliente_id" />
    <?php $client = ""; if(isset($cliente->nombre1)) $client =$cliente->nombre1.' '.$cliente->apellido1; ?>
    ><input type="text"  id="nombre_id" value="<?= $client ?>" readonly />
    <?= $form->field($model, 'idcli')->hiddenInput(['maxlength' => true])->label(false) ?>

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
          <td colspan="3"></td>
          <td colspan="2">
               <?= $form->field($model, 'total')->textInput(['readonly' => true]) ?>
          </td>
        </tr>  
        <tr><td colspan="5"><br /></td></tr>

        <tr>
            <td>
                <input type="hidden" name="totalant" id="totalant" value="<?= $totalant; ?>"></input>
                <?php echo $form->field($modelfd, 'idpro')->dropDownList($productos,
            ['prompt'=>'-Seleccionar Producto',
              'onchange'=>'
                $.get( "index.php?r=facturah/listprice&id="+$(this).val(), function( data ) {
                  $( "#facturad-valor" ).val( data );
                  $( "#facturad-vlr1" ).val( data );
                  $( "#facturad-neto" ).val( data );
                  $( "#facturad-total" ).val( data );
                  $total = parseInt(data) + parseInt($("#totalant").val());
                  $( "#facturad-qty" ).val( 1 );
                  $( "#facturah-total" ).val( $total );
                  $( "#faccredito-saldo" ).val($total);
                  $( "#faccredito-abono" ).val(0);

                });
            ']); 

            ?>

<!--Boton para agregar producto -->
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Agregar Producto' : 'Agregar producto a la factura', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                </div>

            </td>
            <td>
            <?= $form->field($modelfd, 'valor')->textInput(['maxlength' => true,
          //  'onkeyup'=>"format(this)", 
            'onkeyup'=>'
                  //Valida solo numeros
                  if( isNaN( $(this).val() ) ) {
                    $(this).val(0);
                  }

                  $totalfd = $(this).val();
                  $totalfd = $totalfd.replace(".","");
                  $totalfd = parseInt( $totalfd );
           
                  $totalfh = $totalfd + parseInt($("#totalant").val());
                  $( "#facturad-total" ).val( $totalfd );
                  $( "#facturad-qty" ).val( 1 );
                  $( "#facturah-total" ).val( $totalfh);
                  $( "#faccredito-saldo" ).val($totalfh);
                  $( "#faccredito-abono" ).val(0);
                  format(this);
            ']);  ?>

            <?= $form->field($modelfd, 'vlr1')->textInput(['maxlength' => true])->hiddenInput()->label(false);?>
            <?= $form->field($modelfd, 'neto')->textInput(['maxlength' => true])->hiddenInput()->label(false);?>
            </td>
            <td>
                <?= $form->field($modelfd, 'qty')->textInput(['maxlength' => true, 'value' =>1,
             'onchange'=>'
                  //Valida solo numeros
                  if( isNaN( $(this).val() ) ) {
                    $(this).val(1);
                  }

                  $qty = $(this).val();

                  $totalfd = $("#facturad-valor").val();
                  $totalfd = $totalfd.replace(".","");
                  $totalfd = parseInt( $totalfd );
                   
                  $totalfd = $totalfd * $qty;
                   
                  $totalfh = parseInt($totalfd) + parseInt($("#totalant").val());
                  
                  $( "#facturad-total" ).val( $totalfd );
                  $( "#facturah-total" ).val( $totalfh);
                  $( "#faccredito-saldo" ).val($totalfh);
                  $( "#faccredito-abono" ).val(0);


            ']); 

                 ?>
                </td>
            <td colspan="2">
                <?= $form->field($modelfd, 'total')->textInput(['readonly' => true]) ?>
            </td>
            
       </tr>
       <tr>
           <td colspan="3">
                
           </td>
           <td colspan="2">
              
              <?php echo $form->field($model, 'tipo')->dropDownList($tipo,
            [ 'onchange'=>'
                  $totalfh = $( "#facturah-total" ).val();
                  $("#faccredito-saldo").val($totalfh);
                  if($(this).val() == "Credito"){
                    $( "#tipo" ).val( "Credito" );
                    document.getElementById("credito").style.display = "block";
                  }else{
                    $( "#tipo" ).val( "Pagada" );
                    document.getElementById("credito").style.display = "none";
                  }
                  
            ']); 
            ?>
            
            <div id="credito" name="credito" style="display: none;">
           
                <?= $form->field($modelcredito, 'abono')->textInput(['maxlength' => true, 
                                                                         'value' =>0,
                'onchange'=>'

                  if( isNaN( $(this).val() ) ) {
                    $(this).val(0);
                  }

                  $totalfh = $( "#facturah-total" ).val();
                  $abono   = parseInt ($(this).val());

                  if($abono > $totalfh){
                    $(this).val(0) ;
                    $abono = 0;
                  }
                  $vlrsaldo = $totalfh - $abono;

                  $( "#faccredito-saldo" ).val($vlrsaldo);
                  $( "#abono" ).val( $abono );
                  $( "#tipo" ).val( "Credito" );
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
       <tr>
       <td colspan="5" align="right">
  <br />
  <?php if(!$model->isNewRecord) {?>
    <?php ActiveForm::end(); ?>
    <?= Html::beginForm(Url::toRoute("facturah/updateend"), "POST") ?>
          <input type="hidden" name="idfh" value="<?= $model->idfh ?>">
          <input type="hidden" name="idemp" value="<?= $model->idemp ?>">
          <input type="text" name="tipo" id="tipo" value="Pagada">
          <input type="hidden" id="abono" name="abono" value="">
        
          <label class="control-label">Crear Cita</label>
          <input type="checkbox" id="cita" name="cita" value="1">
                         
          <button type="submit" class="btn btn-primary">Guardar Factura</button>
    <?= Html::endForm() ?>
  <?php } ?>
      </td>
  </table>
</div>

<script type="text/javascript">
  function format(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
 
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\.]*/g,'');
}
}
</script>
