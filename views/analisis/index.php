<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use kartik\date\DatePicker;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

$this->title = $emp->nombre.' Evaluacion';
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
<h2>Evaluación </h2>
<div class="row">
   <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4 col-md-4">
      <div class="panel panel-default">
         <div class="panel-body">
           <?= Html::beginForm(Url::toRoute("analisis/viewplan"), "POST") ?>
            
           <h3>Plan de Mercadeo</h3>
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
           <br />
           <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
           <button name="btn" type="submit" class="btn btn-primary">Buscar</button>
           <?= Html::endForm() ?>
      </div>
    </div>
   </div>
   <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4 col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
  
         <?= Html::beginForm(Url::toRoute("analisis/ventas"), "POST") ?>
          
         <h3>Ingresos por ventas</h3>
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
         <br />
                 <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
                 <button type="submit" class="btn btn-primary">Buscar</button>
           <?= Html::endForm() ?>
      </div>
     </div>
   </div>
   <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4 col-md-4">
      <div class="panel panel-default">
         <div class="panel-body">

<?= Html::beginForm(Url::toRoute("analisis/productos"), "POST") ?>
 
<h3>Productos mas vendidos</h3>
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
<br />
        <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
  <?= Html::endForm() ?>

      </div>
    </div>
   </div>
</div>

<div class="row">
   <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/clientes"), "POST") ?>
          
         <h3>Clientes</h3>
         
            <select name="tipo" class="form-control">
              <option value="Institucional">Institucional</option>
              <option value="Individual">Individual</option>
              <option value="Potencial">Potencial</option>
              <option value="Todos">Todos</option>
            </select>
            <br />
            <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
            <input type="hidden" id="btn" name="btn" value="Nopdf">
            <button type="submit" class="btn btn-primary">Buscar</button>
         <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>
   <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/clientesproductos"), "POST") ?>
          
         <h3>Productos por clientes</h3>
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
         <br />
                 <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
                <input type="hidden" name="pro_id" id="pro_id" />
                 <input type="hidden" name="tipo" id="tipo" />
                 <button type="submit" class="btn btn-primary">Buscar</button>
           <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>

   <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/clientesfrecuencia"), "POST") ?>
          
         <h3>Frecuencia de Clientes</h3>
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
         <br />
           <input type="hidden" name="cliente_id" id="cliente_id" />
           <input type="hidden" name="tipo" id="tipo" />
           <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
           <button type="submit" class="btn btn-primary">Buscar</button>
           <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>
</div>   

<div class="row">
 <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/indicadores"), "POST") ?>
          
         <h3>Indicadores</h3>
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
         <br />
                 <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
                 <button type="submit" class="btn btn-primary">Buscar</button>
           <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>
</div>   
