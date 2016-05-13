<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

use yii\jui\AutoComplete;
use yii\web\JsExpression;

use app\models\Empresa;

 
/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas';
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
<a class="btn btn-success" href="<?= Url::toRoute("empresa/create") ?>">Nueva Empresa</a>


<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("empresa/index"),
    "enableClientValidation" => true,
]);
?>
<div class="form-group">
    <?= $f->field($form, "q")->input("search") ?>
</div>
<?= Html::submitButton("Buscar", ["class" => "btn btn-primary"]) ?>
<?php $f->end() ?>
<h3><?= $search ?></h3>


<h3>Lista de Empresas</h3>
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
              Información /
            </a>
            <!--End Inf.-->
             <!-- Cargo todo el plan de marketing con su inf. que esta en pmcontenido -->
            <a href="<?= Url::toRoute(["pmcontenido/index", "id" => $row->idemp,"activo" => "pm1"]) ?>" title="Planmarketing" aria-label="planmarketing">
              Plan Marketing 
            </a>
            <!--End -->
            
            <!-- Plan de Accion -->
            <a href="<?= Url::toRoute(["planaccion/index", "id" => $row->idemp]) ?>" title="Planaccion" aria-label="planaccion">
              / Plan Accion
            </a>
            <!--End -->

            <!-- Clientes -->
            <a href="<?= Url::toRoute(["cliente/index", "idemp" => $row->idemp]) ?>" title="Clientes" aria-label="clientes">
              / Clientes
            </a>
            <!--End -->

            <!-- Ventas -->
            <a href="<?= Url::toRoute(["facturah/index", "idemp" => $row->idemp]) ?>" title="Ventas" aria-label="ventas">
              / Ventas
            </a>
            <!--End -->

             <!-- Agenda -->
            <a href="<?= Url::toRoute(["cita/index", "idemp" => $row->idemp]) ?>" title="Agenda" aria-label="Agenda">
              / Agenda
            </a>
            <!--End -->

            <!-- Analisis -->
            <a href="<?= Url::toRoute(["analisis/index", "idemp" => $row->idemp]) ?>" title="Analisis" aria-label="Analisis">
              / Evaluación
            </a>
            <!--End -->
        </td>
        <td>
        
            <!-- View -->
            <a href="<?= Url::toRoute(["empresa/view", "id" => $row->idemp]) ?>" title="Ver" aria-label="Ver">
              <span class="glyphicon glyphicon-eye-open"></span>
            </a>
            <!--End View-->
        
            <!-- Update -->
            <a href="<?= Url::toRoute(["empresa/update", "id" => $row->idemp]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
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

<?= LinkPager::widget([
    "pagination" => $pages,
]);