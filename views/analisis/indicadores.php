<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = $emp->nombre.' - Indicadores';
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
 <?= Html::beginForm(Url::toRoute("analisis/indicadores"), "POST") ?>

<div class="row">
     <div class="col-sm-4">
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
    </div>
    <div class="col-sm-4">

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
    </div>
    <div class="col-sm-4">
        <br />
        <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
        <button type="submit" class="btn btn-primary">Indicadores</button>
    </div>    
</div>

      
<?= Html::endForm() ?>
<br />
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre Indicador</th>
        <th>Descripcion</th>
        <th>Formula</th>
        <th>Resultado</th>
    </tr>
    <?php foreach($model as $row): ?>
    <?php endforeach ?>    
    <tr>
        <td>Ventas</td>
        <td>
            <p>
                Indica el valor total en pesos de las ventas realizadas por periodo de tiempo   
            </p>
        </td>
        <td>
            <p>
                Ingreso por ventas ($)
            </p>
        </td>
        <td>Resultado</td>
    </tr>
    <!-- Segundo Indicador -->
    <tr>
        <td>Costo del plan de mercadeo </td>
        <td>
            <p>
                Indica el costo total del plan de mercadeo presupuestado a un año 
            </p>
        </td>
        <td>
            <p>
                Costo total del presupuesto de los 4 planes de acción ($)
            </p>
        </td>
        <td>Resultado</td>
    </tr>
    <!-- Tercer Indicador -->
    <tr>
        <td>Indice general de satisfacción</td>
        <td>
            <p>
                Indica el grado de satisfaccion de los clientes, de acuerdo a la información arrojada por las encuestas de satisfacción de clientes 
            </p>
        </td>
        <td>
            <p>
                (número de clientes satisfechos/número total de clientes)*100
            </p>
        </td>
        <td>Resultado</td>
    </tr>
    <!-- Cuarto Indicador -->
    <tr>
        <td>Grado de penetración en el mercado</td>
        <td>
            <p>
                Indica el numero de clientes nuevos que obtubo la empresa en un periodo de tiempo determinado 
            </p>
        </td>
        <td>
            <p>
                número de clientes nuevos por periodo de tiempo
            </p>
        </td>
        <td>Resultado</td>
    </tr>
    <!-- Quinto Indicador -->
    <tr>
        <td>Tasa de retención de clientes </td>
        <td>
            <p>
                Mide el grado de recompra de los clientes de la empresa
            </p>
        </td>
        <td>
            <p>
                (clientes que repiten compra/total clientes)*100
            </p>
        </td>
        <td>Resultado</td>
    </tr>
    <!-- Sexto Indicador -->
    <tr>
        <td>Desarrollo de la empresa (clientes)</td>
        <td>
            <p>
                Mide el comportamiento de los clientes en el año 1 frente al comportamiento de lo clientes en el año anterior 
            </p>
        </td>
        <td>
            <p>
                (# de clientes de la empresa año N/# clientes año N-1)*100
            </p>
        </td>
        <td>Resultado</td>
    </tr>
</table>
