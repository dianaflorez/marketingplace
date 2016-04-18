<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

$title = 'Plan Accion '.$emp->nombre.' - trimestre '.$trimestre.' ('.$fectri.') ';
$this->params['breadcrumbs'][] = $title;
?>

<h3>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $emp->idemp]) ?>">
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
<?php if($trimestre != 1) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 1]) ?>">Trimestre uno</a>
<?php } ?>

<?php if($trimestre != 2) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 2]) ?>">Trimestre dos</a>
<?php } ?>

<?php if($trimestre != 3) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 3]) ?>">Trimestre tres</a>
<?php } ?>

<?php if($trimestre != 4) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 4]) ?>">Trimestre cuatro</a>
<?php } ?>

<br />
<br />

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("planaccion/index"),
    "enableClientValidation" => true,
]);
?>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Elemento</th>
        <th>Costo</th>
        <th>Estado</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td>
            <?= $row['nombre']; ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($acciones as $acc): ?>
                        
                        <?php
                            if($acc->idpa == $row['idpa']){ 
                                echo $acc->descripcion."<br />";
                            }    
                         ?>
                            
                    
                    <?php endforeach ?>
                </div>
            </div>    
          </td>
        <td><?= $row['fecini'] ?></td>
        <td><?= $row['fecfin'] ?></td>
        <td><?= $row['responsable'] ?></td>
        <td>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($elementos as $ele): ?>
               
                        <?php 
                            if($ele->idpa == $row['idpa']){
                                echo $ele->descripcion."<br />";
                            } ?>
                    
                    <?php endforeach ?>
                </div>
            </div>    
          
        </td>
        <td><?= $row['costo'] ?></td>
        <td><?= $row['estado'] ?></td>
       
    </tr>
    <?php endforeach ?>
</table>
