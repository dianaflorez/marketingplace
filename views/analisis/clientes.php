<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

$title = $emp->nombre.' - '.$cliente;
$this->params['breadcrumbs'][] = $title;
?>
<h3>
<a href="<?= Url::toRoute(["analisis/index",  "idemp" => $emp->idemp]) ?>">
    <?= $title ?>
</a>
</h3>   

 <?= $f=Html::beginForm(Url::toRoute("analisis/clientes"), "POST", ['name'=>"formpdf"]) ?>
    <h3>Clientes</h3>
      <div class="row">
         <div class="col-md-4">
            <select class="form-control" name="tipo" >
              <option value="Institucional">Institucional</option>
              <option value="Individual">Individual</option>
              <option value="Esporadico">Esporádico</option>
              <option value="Todos">Todos</option>
              <option value="<?= $cliente ?>" selected="selected"> <?= $cliente ?> </option>
            </select>
          </div>
          <div class="col-md-5">
            <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
            <input type="hidden" id="btn" name="btn" value="10">

            <button type="submit" class="btn btn-primary">Buscar</button>
            <button type="submit" class="btn btn-danger"
                onclick='$("#btn").val("pdf"); '
                >Ver Pdf</button>
          </div>
      </div>      
         <?= Html::endForm() ?>
    
<br />
<br />
<div class="rwd">
<table class="table table-striped  table-bordered table-showPageSummary">
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
</div>