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

$this->title = 'Plan Accion';
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
<a class="btn btn-info" href="<?= Url::toRoute(["planaccion/create", "id" => $idemp]) ?>">Nuevo Plan de Accion</a>
<a class="btn btn-info" href="<?= Url::toRoute(["planaccion/ver", "id" => $idemp]) ?>">Ver Plan de Accion</a>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("planaccion/index"),
    "enableClientValidation" => true,
]);
?>

<h3>Plan de Accion</h3>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Elemento</th>
        <th>Costo</th>
        <th>Estado</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td>
            <?= $row->nombre ?>
            <a  href="<?= Url::toRoute(["accion/create", 
                                    "idpa"    => $row->idpa, 
                                    "idemp" => $row->idemp, 
                                ]) ?>">
            Agregar Accion</a>    
        </td>
        <td><?= $row->fecini ?></td>
        <td><?= $row->fecfin ?></td>
        <td><?= $row->responsable ?></td>
        <td>...</td>
        <td><?= $row->costo ?></td>
        <td><?= $row->estado ?></td>
        <td>
          
            <!-- Update -->
            <a href="<?= Url::toRoute(["planaccion/update", "id" => $row->idpa]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-eye-open"></span>
            </a>
            <!--End Update-->
        
        </td>
    </tr>
    <?php endforeach ?>
</table>
