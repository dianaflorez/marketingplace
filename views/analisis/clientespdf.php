<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;

$title = $emp->nombre.' - Cliente '.$cliente;
$this->params['breadcrumbs'][] = $title;
?>
<h3>
  <?= $title ?>
</h3>   

 <?= Html::beginForm(Url::toRoute("analisis/clientes"), "POST") ?>
    <h3>Clientes</h3>
     
<br />
<table border="1" cellspacing=0 cellpadding=2 bordercolor="#cc0000" align="center">

    <tr>
        <th>No</th>
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
    </tr>
    <?php $ct = 1; ?>
    <?php foreach($model as $row): ?>
    <tr>
            <td><?php echo $ct; $ct++; ?></td>
        <?php if($cliente == "Institucional") {?>
            <td><?= $row->nombre1 ?> </td>
            <td><?= $row->nit ?></td>
        <?php }elseif($cliente == "Individual" || $cliente == "Esporadico" ){ ?>
            <td><?= $row->nombre1.' '.$row->nombre2.' '.$row->apellido1.' '.$row->apellido2?></td> 
        <?php }elseif($cliente == "Todos" ){ ?>
            <td>
              <?= $row->tipo.' - '.$row->nombre1.' '.$row->nombre2.' '.$row->apellido1.' '.$row->apellido2?>
            </td> 
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
                        <?php    echo $dir->dirtel."<br />";
                    }
                 endforeach ?>    
             </div>
            </div>
        </td>
        <td>
              <div class="panel panel-default">
                <div class="panel-body">
             
                <?php foreach($dirtel as $tel) :
                    if($tel->idtipo == 13 && $tel->idtabla == $row->idcli){ ?>
                        <?php    echo $tel->dirtel."<br />";
                    }
                 endforeach ?>    
             </div>
            </div>
         
        </td>
        <td><?= $row->email ?></td>
        <?php if($cliente == "Institucional") {?>
            <td>Sitio Web</td>
        <?php } ?>    
        <td><?= $row->estado ?></td>
      </tr>
    <?php endforeach ?>
</table>
