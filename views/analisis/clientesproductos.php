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

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = $emp->nombre.' - Clientes Productos';
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

<?= Html::beginForm(Url::toRoute("analisis/clientesproductos"), "POST") ?>
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
    <div class="col-xs-7 col-md-4">
    <br />

        <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
        <button type="submit" class="btn btn-primary">Productos</button>
    </div>
</div>        
<?= Html::endForm() ?>
<br />
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Tipo</th>
        <th>Clientes</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Valor Pagado</th>
    </tr>
    <?php $suma = 0; ?>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row['tipo'] ?></td>
        <td><?= $row['nom'] ?></td>
        <td><?= $row['nombre'] ?></td>
        <td><?= $row['ctq'] ?></td>
        <td align="right">
            <?php $total = $row['vlr'];
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $total);
            $suma = $suma + $total;
            ?>
        </td>
    </tr>
    <?php endforeach ?>

    <tr>
         <td colspan="4" align="right"><b>TOTAL Vendido:</b></td>
         <td align="right">
            <?php 
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $suma);
            ?>
        </td>
    </tr>
</table>
