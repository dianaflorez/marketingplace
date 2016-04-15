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
<a class="btn btn-info" href="<?= Url::toRoute(["facturah/create", "id" => $idemp]) ?>">Nuevo Venta</a>
<a class="btn btn-info" href="<?= Url::toRoute(["producto/create", "id" => $idemp]) ?>">Nuevo Producto</a>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("planaccion/index"),
    "enableClientValidation" => true,
]);
?>

<h3>Plan de Accion <?php echo ' - '.$emp->nombre;?></h3>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Elemento</th>
        <th>Costo</th>
        <th>Estado</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td>
            <?= $row->nombre ?>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($row->accions as $acc): ?>
                        
                        <!-- Update -->
                        <a href="<?= Url::toRoute(["accion/update", "id" => $acc->idaccion]) ?>" 
                                    title="Actualizar" aria-label="Actualizar">
                          <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <!--End Update-->
 <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idaccion_<?= $acc->idaccion ?>" title="Eliminar" aria-label="Eliminar">
                <span class="glyphicon glyphicon-trash"></span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="idaccion_<?= $acc->idaccion ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Accion</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar esta accion: <?= $acc->descripcion ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("accion/delete"), "POST") ?>
                                    <input type="hidden" name="idaccion" value="<?= $acc->idaccion ?>">
                                    <input type="hidden" name="idemp" value="<?= $acc->idemp ?>">
                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </a>
            <!--End Delete-->
                        <?php echo $acc->descripcion; ?><br />
                    
                    <?php endforeach ?>
                </div>
            </div>    
            <a  href="<?= Url::toRoute(["accion/create", 
                                    "idpa"    => $row->idpa, 
                                    "idemp" => $row->idemp, 
                                ]) ?>">
            Agregar Accion</a>    
        </td>
        <td><?= $row->fecini ?></td>
        <td><?= $row->fecfin ?></td>
        <td><?= $row->responsable ?></td>
        <td>
            

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($row->elementos as $ele): ?>
                        
                        <!-- Update -->
                        <a href="<?= Url::toRoute(["elemnto/update", "id" => $ele->idele]) ?>" 
                                    title="Actualizar" aria-label="Actualizar">
                          <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <!--End Update-->

                        <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idele_<?= $ele->idele ?>" title="Eliminar" aria-label="Eliminar">
                <span class="glyphicon glyphicon-trash"></span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="idele_<?= $ele->idele ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Accion</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar esta elemento: <?= $ele->descripcion ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("elemento/delete"), "POST") ?>
                                    <input type="hidden" name="idele" value="<?= $ele->idele ?>">
                                    <input type="hidden" name="idemp" value="<?= $ele->idemp ?>">
                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </a>
            <!--End Delete-->
 
                        <?php echo $ele->descripcion; ?><br />
                    
                    <?php endforeach ?>
                </div>
            </div>    
            <a  href="<?= Url::toRoute(["elemento/create", 
                                    "idpa"    => $row->idpa, 
                                    "idemp" => $row->idemp, 
                                ]) ?>">
            Agregar Elemento</a>           

        </td>
        <td><?= $row->costo ?></td>
        <td><?= $row->estado ?></td>
        <td>
          
            <!-- Update -->
            <a href="<?= Url::toRoute(["planaccion/update", "id" => $row->idpa]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
        
        </td>
    </tr>
    <?php endforeach ?>
</table>
