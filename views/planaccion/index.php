<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

$this->title = 'Plan Accion - '.$emp->nombre;
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
<!--
<a class="btn btn-info" href="<?= Url::toRoute(["planaccion/create", "id" => $idemp]) ?>">Nuevo Plan de Accion</a>
-->
<a class="btn btn-info" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp]) ?>">Ver Plan de Accion</a>

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
        <td colspan="7">
            <b><?= $row->nombre ?></b>
        <td>
    </tr>        
    <?php $suma = 0;?>
    <?php foreach($row->paaccions as $acc): ?>
    <tr>
        <td><?= $acc->descripcion ?></td>
        <td><?= $acc->fecini ?></td>
        <td><?= $acc->fecfin ?></td>
        <td><?= $acc->responsable ?></td>
        <td>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($row->paaelementos as $ele): ?>
                      <?php if($ele->idaccion == $acc->idaccion){?>
                        
                        <!-- Update -->
                        <a href="<?= Url::toRoute(["paaelemento/update", 
                                                    "id" => $ele->idele,
                                                    "pa" => $row->nombre]) ?>" 
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
                              <?= Html::beginForm(Url::toRoute("paaelemento/delete"), "POST") ?>
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
                      <?php }?>
                    <?php endforeach ?>
                </div>
            </div>    
            <a  href="<?= Url::toRoute(["paaelemento/create", 
                                    "idpa"  => $row->idpa, 
                                    "idemp" => $row->idemp, 
                                    "idaccion" => $acc->idaccion,
                                    "pa"    => $row->nombre,
                                ]) ?>">
            Agregar Elemento</a>           

        </td>
        <td align="right">
            <?php $costo = $acc->costo ?>
                        <?php
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo  money_format('%.2n', $costo);
                        ?>    
                        <?php $suma = $suma + $costo; ?>
        </td>
        <td><?= $acc->estado ?></td>
        <td>
          
            <!-- Update -->
            <a href="<?= Url::toRoute(["paaccion/update", "id" => $acc->idaccion]) ?>" 
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
                              <?= Html::beginForm(Url::toRoute("paaccion/delete"), "POST") ?>
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
                </div>
            </div>    
        
        </td>
    </tr>
                <?php endforeach ?>
  <tr>
            <td colspan="5" align="right">
                <b>Total <?= $row->nombre ?>:</b>
            </td>
        
            <td  align="right">
                <?php
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $suma = money_format('%.2n', $suma);
                ?>
                <b><?= $suma ?></b>
            </td>
            <td colspan="2"></td>
        </tr>  
    <tr>
      <td colspan="8">
           <a  href="<?= Url::toRoute(["paaccion/create", 
                                    "idpa"    => $row->idpa, 
                                    "idemp" => $row->idemp, 
                                    "pa"    => $row->nombre,
                                ]) ?>">
            Agregar Accion <?=$row->nombre ?></a>
      </td>
    </tr>                    
    <?php endforeach ?>
</table>
