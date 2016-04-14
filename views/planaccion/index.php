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


<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("empresa/index"),
    "enableClientValidation" => true,
]);
?>

<h3>Plan de Accion</h3>
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Id</th>
        <th>
            Nombre
        </th>
        <th>Nit</th>
        <th class="action-column ">&nbsp;</th>
        <th class="action-column ">&nbsp;</th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->idemp ?></td>
        <td><?= $row->nombre ?></td>
        <td><?= $row->nit ?></td>
        <td>
             <!-- Inf. -->
            <a href="<?= Url::toRoute(["empresainf/index", "id" => $row->idemp]) ?>" title="Informacion" aria-label="Informacion">
              <span class="glyphicon glyphicon-list-alt"></span>
            </a>
            <!--End Inf.-->
        
            <!-- Update -->
            <a href="<?= Url::toRoute(["empresa/update", "id" => $row->idemp]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-eye-open"></span>
            </a>
            <!--End Update-->
        
            <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idemp_<?= $row->idemp ?>" title="Eliminar" aria-label="Eliminar">
             <span class="glyphicon glyphicon-trash">.</span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="idemp_<?= $row->idemp ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Empresa</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar esta empresa con nit <?= $row->nit ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("empresa/delete"), "POST") ?>
                                    <input type="hidden" name="idemp" value="<?= $row->idemp ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </a>
            <!--End Delete-->
        </td>
    </tr>
    <?php endforeach ?>
</table>
