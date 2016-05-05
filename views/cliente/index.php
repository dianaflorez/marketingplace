<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

$this->title = $emp->nombre.' - '.$cliente;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

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
<?php if($cliente != "Institucional") { ?>
<a class="btn btn-info" href="<?= Url::toRoute(["cliente/index", 
                                                        "idemp" => $emp->idemp,             
                                                        "cliente"   => "Institucional"]) 
                                                        ?>">Clientes Institucionales</a>
<?php }else{ ?>
<a class="btn btn-warning" href="<?= Url::toRoute(["cliente/index", 
                                                        "idemp" => $emp->idemp,             
                                                        "cliente"   => "Institucional"]) 
                                                        ?>">Clientes Institucionales</a>
<?php } ?>
<?php if($cliente != "Individual") { ?>
<a class="btn btn-info" href="<?= Url::toRoute(["cliente/index", 
                                                        "idemp" => $emp->idemp,             
                                                        "cliente"   => "Individual"]) 
                                                        ?>">Clientes Individuales</a>
<?php }else{ ?>
<a class="btn btn-warning" href="<?= Url::toRoute(["cliente/index", 
                                                        "idemp" => $emp->idemp,             
                                                        "cliente"   => "Individual"]) 
                                                        ?>">Clientes Individuales</a>
<?php } ?>

<?php if($cliente != "Esporadico") { ?>
<a class="btn btn-info" href="<?= Url::toRoute(["cliente/index", 
                                                        "idemp" => $emp->idemp, 
                                                        "cliente"   => "Esporadico"]) 
                                                        ?>">Clientes Esporadicos</a>
<?php }else{ ?>
<a class="btn btn-warning" href="<?= Url::toRoute(["cliente/index", 
                                                        "idemp" => $emp->idemp, 
                                                        "cliente"   => "Esporadico"]) 
                                                        ?>">Clientes Esporadicos</a>
<?php } ?>
<a class="btn btn-danger" href="<?= Url::toRoute(["cita/index", 
                                                        "idemp" => $emp->idemp
                                                        ]) 
                                                        ?>">Agenda</a>

<div class="pull-right">
<?php if($cliente == "Institucional") { ?>
<a class="btn btn-success" href="<?= Url::toRoute(["cliente/create", 
                                                        "idemp"     => $emp->idemp,
                                                        "cliente"   => "Institucional"]) 
                                                        ?>">Nuevo Cliente</a>
<?php }elseif($cliente == "Individual") { ?>
<a class="btn btn-success" href="<?= Url::toRoute(["cliente/create", 
                                                        "idemp"     => $emp->idemp,
                                                        "cliente"   => "Individual"]) 
                                                        ?>">Nuevo Cliente</a>

<?php }elseif($cliente == "Esporadico") { ?>
<a class="btn btn-success" href="<?= Url::toRoute(["cliente/create", 
                                                        "idemp"     => $emp->idemp,
                                                        "cliente"   => "Esporadico"]) 
                                                        ?>">Nuevo Cliente</a>
<?php } ?>

</div>
<br />
<br />
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <?php if($cliente == "Institucional") {?>
            <th>Nit</th>
        <?php }elseif($cliente == "Individual"){ ?>
            <th>Identificacion</th>
            <th>Nacimiento</th>
        <?php }?>
        <th>Direccion</th>
        <th>Telefono</th>
        <th>Email</th>
        <?php if($cliente == "Institucional") {?>
            <th>Sitio Web</th>
        <?php } ?>    
        <th>Estado</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <?php if($cliente == "Institucional") {?>
            <td><?= $row->nombre1 ?> </td>
            <td><?= $row->nit ?></td>
        <?php }elseif($cliente == "Individual" || $cliente == "Esporadico"){ ?>
            <td><?= $row->nombre1.' '.$row->nombre2.' '.$row->apellido1.' '.$row->apellido2?></td> 
        <?php }
       if($cliente == "Individual"){ ?>
            <td><?= $row->identificacion ?></td>
            <td><?= $row->fecnac ?></td>
        <?php } ?>    
        <td>
            <div class="panel panel-default">
                <div class="panel-body">
             
                <?php foreach($dirtel as $dir) :
                    if($dir->idtipo == 11 && $dir->idtabla == $row->idcli){ ?>
                        <!-- Update -->
                        <a href="<?= Url::toRoute(["dirtel/update", 
                                                    "id"    => $dir->iddirtel,
                                                    "lbl"   => "Direccion",
                                                    "cliente"=> $cliente,    
                                                    ]) ?>" 
                                    title="Editar" aria-label="Editar">
                          <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <!--End Update-->
   <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#iddirtel_<?= $dir->iddirtel ?>" title="Eliminar" aria-label="Eliminar">
                <span class="glyphicon glyphicon-trash"></span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="iddirtel_<?= $dir->iddirtel ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Accion</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar esta elemento: <?= $dir->dirtel ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("dirtel/delete"), "POST") ?>
                                  <input type="hidden" name="iddirtel" value="<?= $dir->iddirtel ?>">
                                  <input type="hidden" name="idemp" value="<?= $dir->idemp ?>">
                                    
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </a>
            <!--End Delete-->
 
                    <?php    echo $dir->dirtel."<br />";
                    }
                 endforeach ?>    
             </div>
            </div>
           <a  href="<?= Url::toRoute(["dirtel/create", 
                                "idemp"     => $row->idemp,
                                "tabla"     => "cliente", 
                                "idtabla"   => $row->idcli, 
                                "idtipo"    => 11, //"Direccion ppal."
                                "cliente"   => $cliente,
                            ]) ?>">
            Agregar Direccion
           </a>
        </td>
        <td>
              <div class="panel panel-default">
                <div class="panel-body">
             
                <?php foreach($dirtel as $tel) :
                    if($tel->idtipo == 13 && $tel->idtabla == $row->idcli){ ?>
                        <!-- Update -->
                        <a href="<?= Url::toRoute(["dirtel/update", 
                                                    "id"    => $tel->iddirtel,
                                                    "lbl"   => "Telefono",
                                                    "cliente"=> $cliente,    
                                                    ]) ?>" 
                                    title="Editar" aria-label="Editar">
                          <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <!--End Update-->
                        <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#iddirtel_<?= $dir->iddirtel ?>" title="Eliminar" aria-label="Eliminar">
                <span class="glyphicon glyphicon-trash"></span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="iddirtel_<?= $dir->iddirtel ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Accion</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar esta elemento: <?= $dir->dirtel ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("dirtel/delete"), "POST") ?>
                                  <input type="hidden" name="iddirtel" value="<?= $dir->iddirtel ?>">
                                  <input type="hidden" name="idemp" value="<?= $dir->idemp ?>">
                                    
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </a>
            <!--End Delete-->
 
                        <?php    echo $tel->dirtel."<br />";
                    }
                 endforeach ?>    
             </div>
            </div>
           <a  href="<?= Url::toRoute(["dirtel/create", 
                                "idemp"     => $row->idemp,
                                "tabla"     => "cliente", 
                                "idtabla"   => $row->idcli, 
                                "idtipo"    => 13, //"Telefono ppal."
                                "cliente"   => $cliente,
                            ]) ?>">
            Agregar Telefono
           </a>
 
        </td>
        <td><?= $row->email ?></td>
        <?php if($cliente == "Institucional") {?>
            <td>Sitio Web</td>
        <?php } ?>    
        <td><?= $row->estado ?></td>
        <td>
            <!-- Update -->
            <a href="<?= Url::toRoute(["cliente/update", 
                                "id"        => $row->idcli,
                                ]); ?>" 
                title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
        
        </td>
    </tr>
    <?php endforeach ?>
</table>
