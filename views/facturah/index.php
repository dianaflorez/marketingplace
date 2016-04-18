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

$this->title = 'Ventas - '.$emp->nombre;
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
<a class="btn btn-info" href="<?= Url::toRoute(["facturah/create", "idemp" => $idemp]) ?>">Nuevo Venta</a>
<a class="btn btn-info" href="<?= Url::toRoute(["producto/index", "id" => $idemp]) ?>">Nuevo Producto</a>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("planaccion/index"),
    "enableClientValidation" => true,
]);
?>

<h3>Plan de Accion <?php echo ' - '.$emp->nombre;?></h3>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Referencia</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>TOTAL</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->fecha ?></td>
        <td><?= $row->idcli ?></td>
        <td><?= $row->refpago ?></td>
        <td><?= $row->tipo ?></td>
        <td><?= $row->estado ?></td>
        <td><?= $row->total ?></td>
        <td>
          
            <!-- Update -->
            <a href="<?= Url::toRoute(["facturah/update", "id" => $row->idfh]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
        
        </td>
    </tr>
    <?php endforeach ?>
</table>
