<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use yii\bootstrap\Tabs;
use kartik\date\DatePicker;


$this->title = $emp->nombre.' - Plan Accion';
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

<h3><?php echo $this->title;?></h3>
<br />
<!--
<a class="btn btn-info" href="<?= Url::toRoute(["planaccion/create", "id" => $idemp]) ?>">Nuevo Plan de Accion</a>
-->
<a class="btn btn-info" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp]) ?>">Ver Plan de Accion</a>
<a class="btn btn-danger" href="<?= Url::toRoute(["planaccion/verpdf", "idemp" => $idemp]) ?>">Ver PDF</a>

<div class="rwd">
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Costo</th>
        <th>Estado</th>
        <th>Elemento</th>
        <th class="action-column ">&nbsp;</th>
    </tr>

    <?php $total = 0;?>

    <?php foreach($model as $row): ?>
    <tr>
        <td colspan="8">
            <div class="letraazul"><?= $row->nombre ?></div>
        </td>
    </tr>        
    <?php $suma = 0;?>
    <?php 
    //ORGANIZACION DEL ARRAY INTERNO PARA ACCIONES
      $acciones = array();
      foreach($row->paaccions as $acc){
        $accele = array(
                      'orden'   =>$acc->orden, 
                      'idaccion'=>$acc->idaccion,
                      'descripcion'   =>$acc->descripcion,
                      'fecini'=>$acc->fecini,
                      'fecfin'=>$acc->fecfin,
                      'responsable' => $acc->responsable,
                      'costo' => $acc->costo,
                      'estado'=> $acc->estado);
        array_push($acciones, $accele);
      }
      $tmp = Array(); 
      foreach($acciones as &$acc) 
          $tmp[] = &$acc["orden"]; 
      array_multisort($tmp, $acciones); 
    ?>

    <?php foreach($acciones as &$acc): ?>
    <tr>
        <td><? //$acc['orden']; ?>
          <?= Html::beginForm(Url::toRoute("paaccion/updateplantilla"), "POST") ?>

            <textarea class="form-control" name="desc"><?= $acc['descripcion'] ?>
            </textarea>
            <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
            <input type="hidden" name="idaccion" value="<?= $acc['idaccion'] ?>">
            <button type="submit" class="btnvacio pull-right">Editar</button>
      
        </td>
        <td>
          <?php
          echo DatePicker::widget([
          'name'  => 'fecini',
          'type' => DatePicker::TYPE_INPUT,
          'value'  => $acc['fecini'],
              'options' => ['placeholder' => 'Ingrese Fecha de Inicio ...'],
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-m-dd'
              ]
          ]);
          ?>   
         <button type="submit" class="btnvacio pull-right">Editar</button>

        </td>
        <td>
          <?php
            echo DatePicker::widget([
            'name'  => 'fecfin',
            'type' => DatePicker::TYPE_INPUT,
            'value'  => $acc['fecfin'],
                'options' => ['placeholder' => 'Ingrese Fecha de Inicio ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-m-dd'
                ]
            ]);
            ?>   
           <button type="submit" class="btnvacio pull-right">Editar</button>
        </td>
        <td>
          <textarea class="form-control" name="responsable"><?= $acc['responsable'] ?></textarea>
           <button type="submit" class="btnvacio pull-right">Editar</button>
        </td>
        
        <td align="right">
            <input type="number" class="form-control" name="costo" 
                  max="99999999" style="text-align:right;"
                  value="<?= $acc['costo'] ?>"   />
            <?php 
              $costo = $acc['costo']; 
              setlocale(LC_MONETARY, 'en_US.UTF-8');
              echo $costof= money_format('%.2n', $costo);
            ?>    
            <?php $suma = $suma + $costo; ?> 
            <button type="submit" class="btnvacio pull-right">Editar</button>
        </td>
        <td>
            <select name="estado" class="form-control">
              <option value="En Ejecucion">En Ejecucion</option>
              <option value="Ejecutado">Ejecutado</option>
              <option value="Pendiente">Pendiente</option>
              <option value="Terminado">Terminado</option>
              <option value="<?= $acc['estado'] ?>" selected="selected"> <?= $acc['estado'] ?> </option>
            </select>
            <button type="submit" class="btnvacio pull-right">Editar</button>
        
         <?= Html::endForm() ?>

         <td>
            <div class="panel panel-default" style="min-width: 140px">
                <div class="panel-body" style="margin: -7px">
                    <?php foreach($row->paaelementos as $ele): ?>
                      <?php if($ele->idaccion == $acc['idaccion']){?>
                        
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
                                    "idaccion" => $acc['idaccion'],
                                    "pa"    => $row->nombre,
                                ]) ?>">
            Agregar Elemento</a>           

        </td>
        <td>
          
            <!-- Update -->
            <a href="<?= Url::toRoute(["paaccion/update", "id" => $acc['idaccion']]) ?>" 
                        title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
            <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idaccion_<?= $acc['idaccion'] ?>" title="Eliminar" aria-label="Eliminar">
                <span class="glyphicon glyphicon-trash"></span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="idaccion_<?= $acc['idaccion'] ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Accion</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar esta accion: <?= $acc['descripcion'] ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("paaccion/delete"), "POST") ?>
                                    <input type="hidden" name="idaccion" value="<?= $acc['idaccion'] ?>">
                                    <input type="hidden" name="idemp" value="<?= $idemp ?>">
                                    
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
                <?php $total = $total + $suma; ?>
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
    <tr>
      <td colspan="5" align="right"><b>TOTAL PLAN ACCION</b> </td>
      <td align="right"><b>
             <?php
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                echo $total = money_format('%.2n', $total);
                ?></b>
               </td>
    </tr>
</table>
</div>
<?php  //IMPORTANTE Sin esto no funciona el menu del logo 
    Tabs::widget(); 
?>

