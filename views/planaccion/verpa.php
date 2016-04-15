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

$this->title = 'Plan Accion - '.$emp->nombre;
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
<a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/verpa", "id" => $idemp, "trimestre" => "t1"]) ?>">Trimestre uno</a>
<a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/verpa", "id" => $idemp, "trimestre" => "t2"]) ?>">Trimestre dos</a>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("planaccion/index"),
    "enableClientValidation" => true,
]);
?>

<h3>Plan de Accion <?php echo ' - '.$emp->nombre;?></h3>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Elemento</th>
        <th>Costo</th>
        <th>Estado</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td>
            <?= $row->nombre ?>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($row->accions as $acc): ?>
                        
                        <?php echo $acc->descripcion; ?><br />
                    
                    <?php endforeach ?>
                </div>
            </div>    
          </td>
        <td><?= $row->fecini ?></td>
        <td><?= $row->fecfin ?></td>
        <td><?= $row->responsable ?></td>
        <td>
            

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($row->elementos as $ele): ?>
                        
                        <?php echo $ele->descripcion; ?><br />
                    
                    <?php endforeach ?>
                </div>
            </div>    
          
        </td>
        <td><?= $row->costo ?></td>
        <td><?= $row->estado ?></td>
       
    </tr>
    <?php endforeach ?>
</table>
