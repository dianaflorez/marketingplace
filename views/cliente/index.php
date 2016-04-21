<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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
<br />
<br />
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <?php if($cliente == "Institucional") {?>
            <th>Nit</th>
        <?php }else{ ?>
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
        <?php }else{ ?>
            <td><?= $row->nombre1.' '.$row->nombre2.' '.$row->apellido1.' '.$row->apellido2?></td> 
            <td><?= $row->identificacion ?></td>
            <td><?= $row->fecnac ?></td>
        <?php } ?>    
        <td>Direccion</td>
        <td>Telefono</td>
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
