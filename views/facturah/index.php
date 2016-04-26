<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ventas - '.$emp->nombre;
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
<a class="btn btn-info" href="<?= Url::toRoute(["facturah/create", "idemp" => $idemp]) ?>">Nuevo Venta</a>
<a class="btn btn-info" href="<?= Url::toRoute(["producto/index", "id" => $idemp]) ?>">Nuevo Producto</a>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("facturah/index"),
    "enableClientValidation" => true,
]);
?>

<h3>Ventas <?php echo ' - '.$emp->nombre;?></h3>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Referencia</th>
        <th>Estado</th>
        <th>TOTAL</th>
        <th>Tipo</th>
        <th>Deuda</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->fecha ?></td>
        <td><?= $row->idcli0->nombre1.' '.$row->idcli0->apellido1 ?></td>
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
           <?php if(trim($row->tipo) == "Credito"){ ?>
            <?php 
             foreach($creditos as $cre):
                if($cre['idfh'] == $row->idfh){
                    $abono = $cre->abono;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo  money_format('%.2n', $abono)." / ";
                }
                endforeach;
             ?>
             <a  href="<?= Url::toRoute(["faccredito/create", 
                                    "idfh"  => $row->idfh,
                                ]) ?>">
            Agregar Abono</a>   
          <?php } else{ echo "$0"; } ?>  
        </td>
         <td>
          
              <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idfh_<?= $row->idfh ?>" title="Eliminar" aria-label="Eliminar">
             <span class="glyphicon glyphicon-trash">.</span>
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
