<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

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

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("planaccion/index"),
    "enableClientValidation" => true,
]);
?>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Referencia</th>
        <th>Estado</th>
        <th>TOTAL</th>
        <th>Tipo</th>
        <th>Deuda</th>
      
    </tr>
    <?php $suma = 0;?>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->fecha ?></td>
        <td><?= $row->idcli0->nombre1.' '.$row->idcli0->apellido1 ?></td>
        <td><?= $row->refpago ?></td>
        <td><?= $row->estado ?></td>
         <td align="right">
            <?php $total = $row->total;
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            echo  money_format('%.2n', $total);
            $suma = $suma + $total;
            ?>
         
        </td>
        <td><?= $row->tipo ?></td>
        <td>cargar tabla de creditos</td>
       
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
         <td  align="right"><b>Deuda:</b></td>
         <td align="right">
        </td>
    </tr>
</table>
