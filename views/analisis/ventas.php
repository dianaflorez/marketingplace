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

$title = 'Ventas - '.$emp->nombre;
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

<?= Html::beginForm(Url::toRoute("analisis/ventas"), "POST") ?>
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
        <button type="submit" class="btn btn-primary">Ventas</button>
<?= Html::endForm() ?>
<br />
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Referencia</th>
        <th>Estado</th>
        <th>Tipo</th>
        <th>TOTAL</th>
    </tr>
    <?php $suma = 0;?>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->fecha ?></td>
        <td><?= $row->idcli0->nombre1.' '.$row->idcli0->apellido1 ?></td>
        <td><?= $row->refpago ?></td>
        <td><?= $row->estado ?></td>
        <td><?= $row->tipo ?></td>
        <td align="right">
            <?php $total = $row->total;
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $total);
            $suma = $suma + $total;
            ?>
         
        </td>
    </tr>
    <?php endforeach ?>

    <tr>
         <td colspan="5" align="right"><b>TOTAL Vendido:</b></td>
         <td align="right">
            <?php 
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $suma);
            ?>
        </td>
    </tr>
</table>