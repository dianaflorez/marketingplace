<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;

//Para autocomplete
use yii\jui\AutoComplete;
use yii\web\JsExpression;

use kartik\date\DatePicker;

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

<?= Html::beginForm(Url::toRoute(["cita/index",  "idemp" => $emp->idemp]), "POST") ?>
<div class="row">
   <div class="col-sm-4 col-md-5">
  
    <?php
    echo '<b>Buscar Cliente</b>' .'<br>';
    echo AutoComplete::widget([    
    'class'=>'form-control',
    'clientOptions' => [
  'class'=>'form-control',
    'source'    => $data,
    'minLength' => '3', 
    'autoFill'  => true,
    'select'    => new JsExpression("function( event, ui ) {
                    $('#cliente_id').val(ui.item.id);//#cliente_id is the id of hiddenInput.
                    $('#nombre_id').val(ui.item.value);
                 }")],
                 ]);
            ?>
    <input type="hidden" name="cliente_id" id="cliente_id" />
    ><input type="text" name="nombre_id" id="nombre_id" readonly />

    </div>
    <div class="col-sm-3 col-md-4">
  
      <?php
        echo '<label class="control-label">Fechas</label>';

        echo DatePicker::widget([
            'name' => 'fecini',
            'value' => date('Y-m-d'),
            'type' => DatePicker::TYPE_RANGE,
            'name2' => 'fecfin',
            'value2' => date('Y-m-d'),
            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-m-dd'
            ]
        ]);
        ?>
    </div>
    
        </div>
    <button type="submit" class="btn btn-info">Buscar</button>
<?= Html::endForm() ?>

    <p class="pull-right">
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
            <div class="panel panel-default">
                <div class="panel-body">
            
                <?php
                foreach($pedidos as $cp):
                    if($cp->idcita == $row->idcita)
                        echo $cp->pedido."<br />";
                endforeach ?>
                </div>
            </div>
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
