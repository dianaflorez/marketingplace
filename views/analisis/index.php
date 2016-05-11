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

$this->title = $emp->nombre.' Analisis';
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
<div class="row">
   <div class="col-sm-4 col-md-4">
      <div class="panel panel-default">
         <div class="panel-body">
           <?= Html::beginForm(Url::toRoute("analisis/viewplan"), "POST") ?>
            
           <h3>Plan de Mercadeo</h3>
           <?php
           echo '<label>Fecha Inicio</label>';
           echo DatePicker::widget([
               'name' => 'fecini', 
               'value' => $fecini,
               'options' => ['placeholder' => 'Fecha Inicial ...'],
               'pluginOptions' => [
                   'todayHighlight' => true,
                   'autoclose'=>true,
                   'format' => 'yyyy-m-dd'
               ]
           ]);
           ?>
           <br />
           <?php
           echo '<label>Fecha Fin</label>';
           echo DatePicker::widget([
               'name' => 'fecfin', 
               'value' => $fecfin,
               'options' => ['placeholder' => 'Fecha Inicial ...'],
               'pluginOptions' => [
                   'todayHighlight' => true,
                   'autoclose'=>true,
                   'format' => 'yyyy-m-dd'
               ]
           ]);
           ?>
           <br />
           <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
           <button name="btn" type="submit" class="btn btn-primary">Generar</button>
           <?= Html::endForm() ?>
      </div>
    </div>
   </div>
   <div class="col-sm-4 col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
  
         <?= Html::beginForm(Url::toRoute("analisis/ventas"), "POST") ?>
          
         <h3>Ventas Ingresos</h3>
         <?php
         echo '<label>Fecha Inicio</label>';
         echo DatePicker::widget([
             'name' => 'fecini', 
             'value' => $fecini,
             'options' => ['placeholder' => 'Fecha Inicial ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
         <?php
         echo '<label>Fecha Fin</label>';
         echo DatePicker::widget([
             'name' => 'fecfin', 
             'value' => $fecfin,
             'options' => ['placeholder' => 'Fecha Inicial ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
                 <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
                 <button type="submit" class="btn btn-primary">Generar</button>
           <?= Html::endForm() ?>
      </div>
     </div>
   </div>
   <div class="col-sm-4 col-md-4">
      <div class="panel panel-default">
         <div class="panel-body">

<?= Html::beginForm(Url::toRoute("analisis/productos"), "POST") ?>
 
<h3>Productos mas vendidos</h3>
<?php
echo '<label>Fecha Inicio</label>';
echo DatePicker::widget([
    'name' => 'fecini', 
    'value' => $fecini,
    'options' => ['placeholder' => 'Fecha Inicial ...'],
    'pluginOptions' => [
        'todayHighlight' => true,
        'autoclose'=>true,
        'format' => 'yyyy-m-dd'
    ]
]);
?>
<br />
<?php
echo '<label>Fecha Fin</label>';
echo DatePicker::widget([
    'name' => 'fecfin', 
    'value' => $fecfin,
    'options' => ['placeholder' => 'Fecha Inicial ...'],
    'pluginOptions' => [
        'todayHighlight' => true,
        'autoclose'=>true,
        'format' => 'yyyy-m-dd'
    ]
]);
?>
<br />
        <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
        <button type="submit" class="btn btn-primary">Generar</button>
  <?= Html::endForm() ?>

      </div>
    </div>
   </div>
</div>

<div class="row">
   <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/clientes"), "POST") ?>
          
         <h3>Clientes</h3>
         
            <select name="tipo" class="form-control">
              <option value="Institucional">Institucional</option>
              <option value="Individual">Individual</option>
              <option value="Esporadico">Esporádico</option>
            </select>
            <br />
            <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
            <button name="btn" type="submit" class="btn btn-primary">Generar</button>
         <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>
   <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/clientesproductos"), "POST") ?>
          
         <h3>Clientes Productos</h3>
         <?php
         echo '<label>Fecha Inicio</label>';
         echo DatePicker::widget([
             'name' => 'fecini', 
             'value' => $fecini,
             'options' => ['placeholder' => 'Fecha Inicial ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
         <?php
         echo '<label>Fecha Fin</label>';
         echo DatePicker::widget([
             'name' => 'fecfin', 
             'value' => $fecfin,
             'options' => ['placeholder' => 'Fecha Inicial ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
                 <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
                <input type="hidden" name="pro_id" id="pro_id" />
                 <input type="hidden" name="tipo" id="tipo" />
                 <button type="submit" class="btn btn-primary">Generar</button>
           <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>

   <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/clientesfrecuencia"), "POST") ?>
          
         <h3>Frequencia Clientes</h3>
         <?php
         echo '<label>Fecha Inicio</label>';
         echo DatePicker::widget([
             'name' => 'fecini', 
             'value' => $fecini,
             'options' => ['placeholder' => 'Fecha Inicial ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
         <?php
         echo '<label>Fecha Fin</label>';
         echo DatePicker::widget([
             'name' => 'fecfin', 
             'value' => $fecfin,
             'options' => ['placeholder' => 'Fecha Inicial ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
           <input type="hidden" name="cliente_id" id="cliente_id" />
           <input type="hidden" name="tipo" id="tipo" />
           <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
           <button type="submit" class="btn btn-primary">Generar</button>
           <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>
</div>   

<div class="row">
 <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-body">
       <?= Html::beginForm(Url::toRoute("analisis/indicadores"), "POST") ?>
          
         <h3>Indicadores</h3>
         <?php
         echo '<label>Fecha Inicio</label>';
         echo DatePicker::widget([
             'name' => 'fecini', 
             'value' => $fecini,
             'options' => ['placeholder' => 'Fecha Inicial ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
         <?php
         echo '<label>Fecha Fin</label>';
         echo DatePicker::widget([
             'name' => 'fecfin', 
             'value' => $fecfin,
             'options' => ['placeholder' => 'Fecha Final ...'],
             'pluginOptions' => [
                 'todayHighlight' => true,
                 'autoclose'=>true,
                 'format' => 'yyyy-m-dd'
             ]
         ]);
         ?>
         <br />
                 <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
                 <button type="submit" class="btn btn-primary">Generar</button>
           <?= Html::endForm() ?>
    
      </div>
    </div>
   </div>
</div>   
