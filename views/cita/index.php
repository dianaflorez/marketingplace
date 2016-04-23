<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;

$this->title = $emp->nombre.' - Agenda';
$this->params['breadcrumbs'][] = $this->title;
?>
<h2>
<a href="<?= Url::toRoute(["cliente/index",  "idemp" => $emp->idemp]) ?>">
    <?php echo $emp->nombre." - Clientes"; ?>
</a>
</h2>   

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
<div class="cita-index">

    <p>
        <?= Html::a('Nueva Cita', ['create',"idemp" => $emp->idemp], ['class' => 'btn btn-success']) ?>
    </p>
  <table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
        <th>Observacion</th>
        <th>Pedido</th>
        <th class="action-column ">&nbsp;</th>
    </tr>

    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->idcli0->nombre1.' '.$row->idcli0->apellido1 ?></td>
        <td><?= $row->fecha ?></td>
        <td><?= $row->hora ?></td>
        <td><?= $row->estado ?></td>
        <td><?= $row->observacion ?></td>
        <td>
            
             <a  href="<?= Url::toRoute(["citapedido/create", 
                                    "idemp"  => $row->idemp, 
                                    "idcita" => $row->idcita,
                                ]) ?>">
            Agregar Pedido</a>           

        </td>
        <td>
              <!-- Update -->
            <a href="<?= Url::toRoute(["cita/update", "id" => $row->idcita, "idemp" =>$row->idemp]) ?>" 
                        title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
          

        </td>
    </tr>        
    <?php endforeach?>
    </table>    
</div>
