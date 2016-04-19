<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $modelemp->nombre;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresainf-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php   echo "nit. ".$modelemp->nit; ?>
    <br /><br />
    <p>
        <a href="<?= Url::toRoute(["empresainf/create", "idemp" => $idemp]) ?>">Nueva Informacion</a>
    </p>

   <?php foreach($model as $row): ?>

    <div class="panel panel-default">
      <div class="panel-heading"><?= $row->idtipo0->nombre ?></div>
      <div class="panel-body">
        <?= $row->inf ?>
        <br /><br />
            <!-- Update -->
            <a href="<?= Url::toRoute(["empresainf/update", "id" => $row->idinf]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
        
            <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idinf_<?= $row->idinf ?>" title="Eliminar" aria-label="Eliminar">
             <span class="glyphicon glyphicon-trash">.</span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="idinf_<?= $row->idinf ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Empresa</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar <?= $row->idtipo0->nombre ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("empresainf/delete"), "POST") ?>
                                    <input type="hidden" name="idinf" value="<?= $row->idinf ?>">
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
      </div>
    </div>

    <?php endforeach ?>

</div>
