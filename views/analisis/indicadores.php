<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use kartik\date\DatePicker;

use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = $emp->nombre.' - Indicadores';
$this->params['breadcrumbs'][] = $title;
?>
<h3>
<a href="<?= Url::toRoute(["analisis/index",  "idemp" => $emp->idemp]) ?>">
    <?= $title ?>
</a>
</h3>   

<h3>
<?php if($msg){ 
        echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $msg,
        ]);
    }
?>
</h3>
 <?= Html::beginForm(Url::toRoute("analisis/indicadores"), "POST") ?>

<div class="row">
     <div class="col-sm-4">
          <?php
            echo '<label class="control-label">Fechas</label>';

            echo DatePicker::widget([
                'name' => 'fecini',
                'value' => $fecini,
                'type' => DatePicker::TYPE_RANGE,
                'name2' => 'fecfin',
                'value2' => $fecfin,
                'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-m-dd'
                ]
            ]);
            ?>
    </div>
    <div class="col-sm-4">
        <br />
        <input type="hidden" name="idemp" id="idemp" value="<?= $emp->idemp ?>">
        <button type="submit" class="btn btn-primary">Indicadores</button>
    </div>    
</div>

      
<?= Html::endForm() ?>

    <?php $form = ActiveForm::begin(); ?>

<br />
<div class="rwd">
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>No.</th>
        <th>Nombre Indicador</th>
        <th width="24%">Descripcion</th>
        <th width="34%">Formula</th>
        <th>Resultado</th>
    </tr>
    <?php //foreach($model as $row): ?>
    <?php //endforeach ?>    
    <tr>
        <td>1</td>
        <td align="center">Ventas</td>
        <td>
            <p>
                Indica el valor total en pesos de las ventas realizadas por periodo de tiempo   
            </p>
        </td>
        <td>
            <p>
                Ingreso por ventas ($)
            </p>
        </td>
        <td align="right">
            <?php $indicador1 = $in1;
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $indicador1);
            ?>
        </td>
    </tr>
    <!-- Segundo Indicador -->
    <tr>
        <td>2</td>
        <td align="center">Costo del plan de mercadeo </td>
        <td>
            <p>
                Indica el costo total del plan de mercadeo presupuestado a un año 
            </p>
        </td>
        <td>
            <p>
                Costo total del presupuesto de los 4 planes de acción ($)
            </p>
        </td>
        <td align="right">
            <?php $indicador2 = $in2;
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $indicador2);
            ?>
        </td>
    </tr>
    <!-- Tercer Indicador -->
    <tr>
        <td>3</td>
        <td align="center">Indice general de satisfacción</td>
        <td>
            <p>
                Indica el grado de satisfaccion de los clientes, de acuerdo a la información arrojada por las encuestas de satisfacción de clientes 
            </p>
        </td>
        <td valign="bottom">
            <p>
                (número de clientes satisfechos/número total de clientes)*100
                <div class="row">
                    <div class="col-md-5">
                        <?= $form->field($model, 'qty')->textInput(['maxlength' => true,
                         'value' =>1,
                         'onchange'=>'
                              //Valida solo numeros
                              if( isNaN( $(this).val() ) ) {
                                $(this).val(1);
                              }
                              if( $(totalcli).val() == 0 || isNaN( $(totalcli).val())){
                                $(totalcli).val(1);
                              }
                              $totalcli = parseInt( $(totalcli).val() );
                              $clisatisfechos = parseInt( $(this).val() );
                              $res = ($clisatisfechos / $totalcli) * 100;
                              $(resin3).val($res.toFixed(2));  

                        '])->label('Clientes satisfechos');
                        ?>
                    </div>
                    <div class="col-md-4">
                         <label class="control-label">Total Clientes</label>
            <input class="form-control" type="text"  name="totalcli" value="<?= $in3; ?>" readonly />
           
                    </div>
                </div>
            
            </p>
        </td>
        <td valign="bottom">
            <br />
            <br />
            <br />
            <label class="control-label">Resultado</label>
            <input class="form-control" type="text" name="resin3" 
                    style="text-align:right;" size="5"
                    value="<?= $in3; ?>%" readonly />
        </td>
    </tr>
    <!-- Cuarto Indicador -->
    <tr>
        <td>4</td>
        <td align="center">Grado de penetración en el mercado</td>
        <td>
            <p>
                Indica el numero de clientes nuevos que obtubo la empresa en un periodo de tiempo determinado 
            </p>
        </td>
        <td>
            <p>
                número de clientes nuevos por periodo de tiempo
            </p>
        </td>
        <td>
            <br /> <b>Resultado</b>
            <input class="form-control" type="text"  name="totalcli" 
                    style="text-align:right;" size="5"
                    value="<?= $in4; ?>" readonly />
        </td>
    </tr>
    <!-- Quinto Indicador -->
    <tr>
        <td>5</td>
        <td align="center">Tasa de retención de clientes </td>
        <td>
            <p>
                Mide el grado de recompra de los clientes de la empresa
            </p>
        </td>
        <td>
            <p>
                (clientes que repiten compra/total clientes)*100
                <div class="row">
                    <div class="col-md-5">
                        <label class="control-label">Clientes Repiten Compra</label>
                        <input class="form-control" type="text"  name="totalcli" value="<?= $in5; ?>" readonly />
                      
                    </div>
                    <div class="col-md-4">
                        <br />
                        <label class="control-label">Total Clientes</label>
                        <input class="form-control" type="text"  name="totalcli" value="<?= $in3; ?>" readonly />
                    </div>    
                </div>
            </p>
        </td>
        <td><br /> <b>Resultado</b>
            <input class="form-control" type="text"  name="totalcli" 
                    style="text-align:right;" size="5"
                    value="<?= $in51; ?>%" readonly />
        </td>
    </tr>
    <!-- Sexto Indicador -->
    <tr>
        <td>6</td>
        <td align="center">Desarrollo de la empresa (clientes)</td>
        <td>
            <p>
                Mide el comportamiento de los clientes en el año 1 frente al comportamiento de lo clientes en el año anterior 
            </p>
        </td>
        <td>
            <p>
                (# de clientes de la empresa año N/# clientes año N-1)*100

                <div class="row">
                   <div class="col-sm-5 col-md-4">
                        <?= Html::beginForm(Url::toRoute("analisis/viewplan"), "POST") ?>
                            
                           <?php
                           echo '<label>Fecha N</label>';
                           echo DatePicker::widget([
                               'name' => 'fecfin1', 
                               'type' => DatePicker::TYPE_INPUT,
                               'value' => $fecfin,

                               'options' => ['placeholder' => 'Fecha Inicial ...',
                                  'onchange'=>' 
    $.get( "index.php?r=analisis/indicadorfec&fec="+$(this).val()+"&id="+$("#idemp").val(), function( data ) { 

            $("#fecn").val(data);
            $cli1 = parseInt(data);

            if( $( "#fecn-1" ).val() ){
                $cli2 = parseInt( $( "#fecn-1" ).val() );
            }
            else {
                $cli2 = 1;
            }

            if( $cli2 ==  0 ){ $cli2 = $cli1; }
           
            $res = ($cli1 / $cli2) * 100;
            $( "#resin6" ).val( $res+"%" );

        });
    ',
                               ],
                               'pluginOptions' => [
                                   'todayHighlight' => true,
                                   'autoclose'=>true,
                                   'format' => 'yyyy-m-dd',
                               ],
                           ]);
                           ?>
                           <br />
                           <?php
                           echo '<label>Fecha N-1</label>';
                           echo DatePicker::widget([
                               'name' => 'fecfin2', 
                               'type' => DatePicker::TYPE_INPUT,
                               'value' => $fecini,
                               'options' => ['placeholder' => 'Fecha Inicial ...',
      'onchange'=>' 
    $.get( "index.php?r=analisis/indicadorfec&fec="+$(this).val()+"&id="+$("#idemp").val(), function( data ) { 
            
            $("#fecn-1").val(data);
            
            $cli1 = parseInt( $("#fecn").val() );

            $cli2 = parseInt( $("#fecn-1").val() );

            if($cli2 ==  0){ $cli2 = $cli1; }
           
            $res = ($cli1 / $cli2) * 100;
            $( "#resin6" ).val( $res+"%" );

});
    ',
                               ],
                               'pluginOptions' => [
                                   'todayHighlight' => true,
                                   'autoclose'=>true,
                                   'format' => 'yyyy-m-dd'
                               ]
                           ]);
                           ?>
                           <br />
                           
                           <?= Html::endForm() ?>
                    </div>
                   <div class="col-sm-5 col-md-5">
                       <br />
                       <b>No Clintes N</b>
                       <input type="text" id="fecn" value="" readonly 
                              class="form-control" style="text-align:right; width: 70px;">
                       <br />
                       <b>No Clintes N-1</b>
                       <input type="text" id="fecn-1" value="" readonly 
                              class="form-control" style="text-align:right; width: 70px;">

                    </div>
                </div>

            </p>
        </td>
        <td><br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <label class="control-label">Resultado</label>
            <input class="form-control" type="text" id="resin6" name="resin6" 
                    style="text-align:right;" size="5"
                    value=" %" readonly />
        </td>
    </tr>
</table>
</div>
    <?php ActiveForm::end(); ?>

