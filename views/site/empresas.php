<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use app\models\Empresainf;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//Para autocomplete
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = 'Empresas';
//$this->params['breadcrumbs'][] = $this->title;
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

<div class="row">

<?= Html::beginForm(Url::toRoute(["site/empresas"]), "POST") ?>
  <div class="col-sm-2 col-md-2">
        <label class="control-label">Buscar Empresas</label>
        <br />
        <?php
        echo AutoComplete::widget([    
        'class'=>'form-control',
        'clientOptions' => [
        'class'=>'form-control',
        'source'    => $data,
        'minLength' => '3', 
        'autoFill'  => true,
        'select'    => new JsExpression("function( event, ui ) {
                        $('#cliente_id').val(ui.item.id);//#cliente_id is the id of hiddenInput.
                        $('#nombre_id').val(ui.item.value);
                     }")],
                     ]);
                ?>
        <input type="hidden" name="cliente_id" id="cliente_id" />
        <b><input type="text" name="nombre_id" id="nombre_id" style="border-width:0;" readonly /></b>

    </div>
    <div class="col-xs-1 col-md-1">
    <br />
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
<?= Html::endForm() ?>

<a class="btn btn-success pull-right" style="margin-right: 27px" href="javascript:history.back(1)">Regresar</a>

<br />
</div>

<div class="row">
    <?php foreach($model as $row): ?>
    <div class="col-md-4"> 
      <div class="panel panel-default">
        <div class="panel-body" style="text-align: center">
          <a href="index.php?r=site%2Fcontact&id=<?=$row->idemp?>">
            <?php 
            foreach($row->infempresas as $log) {
              if($log->idemp == $row->idemp && $log->idtipo ==10){
                if($log->descripcion)
                  echo Html::img($log->descripcion,["height"=>"70px"]);
              }
            } 
            ?>
            <br />
        
            <?= $row->nombre ?><br />
            <?= $row->nit ?>
          </a>
        </div>
      </div>
    </div>
    <?php endforeach ?>
</div>

