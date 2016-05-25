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

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("empresa/index"),
    "enableClientValidation" => true,
]);
?>
<a class="btn btn-info pull-right" style="margin-right: 27px" href="javascript:history.back(1)">Regresar</a>

<h3>Lista de Empresas</h3>

<div class="row">
    <?php foreach($model as $row): ?>
    <div class="col-md-4"> 
      <div class="panel panel-default">
        <div class="panel-body">
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

