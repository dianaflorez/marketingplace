<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Productos - '.$emp->nombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<a class="btn btn-success" href="<?= Url::toRoute(["producto/create", "id" => $idemp]) ?>">Nuevo Producto</a>
<a class="btn btn-info" href="<?= Url::toRoute(["facturah/index", "id" => $idemp]) ?>" > Ventas </a>
    </p>
 <table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Vlr. sin iva</th>
        <th>iva</th>
        <th>estado</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->codigo ?></td>
        <td><?= $row->nombre ?></td>
        <td><?= $row->descripcion ?></td>
        <td><?= $row->vlrsiniva ?></td>
        <td><?= $row->iva ?></td>
        <td><?= $row->estado ?></td>
        <td>
          
            <!-- Update -->
            <a href="<?= Url::toRoute(["producto/update", "id" => $row->idpro]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
        
        </td>
    </tr>
    <?php endforeach ?>
</table>
