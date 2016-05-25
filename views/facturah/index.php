<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

//Para autocomplete
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $emp->nombre.' - Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>

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
<div class="row">
  <div class="col-xs-10 col-sm-5">
    <br />
    <a class="btn btn-info" href="<?= Url::toRoute(["facturah/create", "idemp" => $idemp]) ?>">Nuevo Venta</a>
    <!--Si el usuario es Comercial no mostrar -->
    <?php if (Yii::$app->user->identity->role != 1){ ?>
      <a class="btn btn-info" href="<?= Url::toRoute(["producto/index", "id" => $idemp]) ?>">Nuevo Producto</a>
    <?php } ?>

   
  </div>
    
<?= Html::beginForm(Url::toRoute(["facturah/index","idemp"=>$emp->idemp]), "POST") ?>
  <div class="col-xs-5 col-sm-3 col-md-2">
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
                     }")],
                     ]);
                ?>
        <input type="hidden" name="cliente_id" id="cliente_id" />
        <b><input type="text" name="nombre_id" id="nombre_id" style="border-width:0;" readonly /></b>

    </div>
    <div class="col-xs-1 col-md-1">
    <br />

        <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
        <button type="submit" class="btn btn-primary">Generar</button>
    </div>
<?= Html::endForm() ?>
</div>

 <?php $f = ActiveForm::begin([
        "method" => "get",
        "action" => Url::toRoute("facturah/index"),
        "enableClientValidation" => true,
    ]);
    ?>
<h3><?php echo $emp->nombre.' ';?> Ventas</h3>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Referencia</th>
        <th>Estado</th>
        <th>TOTAL</th>
        <th>Tipo</th>
        <th>Credito</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= substr($row->fecha, 0,16) ?></td>
        <td>
          <?php if($row->idcli0){ ?>
            <?= $row->idcli0->nombre1.' '.$row->idcli0->apellido1 ?>
          <?php } ?>
        </td>
        <td><?= $row->refpago ?></td>
        <td><?= $row->estado ?></td>
        <td align="right">
            <?php $total = $row->total;
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $total);
            ?>
         
        </td>
        <td><?= $row->tipo ?></td>
        <td align="right">
           <?php if(trim($row->tipo) == "Credito" || trim($row->tipo) == "PagadaCred" ){ ?>
            <?php $totalabono = 0;
             foreach($creditos as $cre):
                if($cre['idfh'] == $row->idfh){
                    $abono = $cre->abono;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo  money_format('%.2n', $abono)."  ";
                    $totalabono = $totalabono + $abono;
                }
                endforeach;
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $totala = money_format('%.2n', $totalabono);
                echo " = <b>".$totala."</b><br />";
                $saldo = $total - $totalabono;
                
                $letracolor = "<font color='#900'>";
                if($saldo == 0 ) $letracolor = "<font color='#090'>";
               
                $saldo = money_format('%.2n', $saldo);
                echo $letracolor."<b>Saldo = ".$saldo."</b></font>";
             ?>
             <?php if($row->total > $totalabono){?>
                        <a  href="<?= Url::toRoute(["faccredito/create", 
                                    "idfh"  => $row->idfh,
                                    "idemp" => $row->idemp,
                                ]) ?>">
                        Agregar Abono</a>   
                  <?php } ?> 

          <?php } else{ echo "$0"; } ?>  
        </td>
         <td>
          
              <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idfh_<?= $row->idfh ?>" title="Eliminar" aria-label="Eliminar">
             <span class="glyphicon glyphicon-trash"></span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="idfh_<?= $row->idfh ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Anular Factura</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas anular esta factura con id <?= $row->idfh ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("facturah/delete"), "POST") ?>
                                    <input type="hidden" name="idfh" value="<?= $row->idfh ?>">
                                    <input type="hidden" name="idemp" value="<?= $row->idemp ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </a>
            <!--End Delete-->
       
        </td>
          
    </tr>
    <?php endforeach ?>
  
</table>
