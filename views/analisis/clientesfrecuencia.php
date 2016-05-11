<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use kartik\date\DatePicker;

//Para autocomplete
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = $emp->nombre.' - Cliente Frecuencia';
$this->params['breadcrumbs'][] = $title;
?>
<h3>
<a href="<?= Url::toRoute(["analisis/index",  "idemp" => $emp->idemp]) ?>">
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

<?= Html::beginForm(Url::toRoute("analisis/clientesfrecuencia"), "POST") ?>
<div class="row">
    <div class="col-xs-7 col-md-3">
        <?php
            echo '<label class="control-label">Fechas</label>';

            echo DatePicker::widget([
                'name' => 'fecini',
                'value' => $fecini,
                'type' => DatePicker::TYPE_RANGE,
                'name2' => 'fecfin',
                'value2' => $fecfin,
                'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-m-dd'
                ]
            ]);
            ?>
    </div>      
     <div class="col-xs-2">
        <label class="control-label">Tipo Clientes</label>

            <select class="form-control" name="tipo" >
              <option value="Todos">Todos</option>
              <option value="Institucional">Institucional</option>
              <option value="Individual">Individual</option>
              <option value="Esporadico">Esporádico</option>
            </select>
    </div>  
    <div class="col-sm-2 col-md-2">
        <label class="control-label">Buscar Cliente</label>
  <br />
        <?php
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
        <b><input type="text" name="nombre_id" id="nombre_id" style="border-width:0;" readonly /></b>

    </div>
    <div class="col-xs-10 col-md-4">
    <br />

        <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
        <button type="submit" class="btn btn-primary">Generar</button>
    </div>
</div>        
<?= Html::endForm() ?>
<br />
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Tipo</th>
        <th>Clientes</th>
        <th>Frecuencia de compra</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row['tipo'] ?></td>
        <td><?= $row['nom'] ?></td>
        <td><?= $row['ct'] ?></td>
    </tr>
    <?php endforeach ?>
</table>
