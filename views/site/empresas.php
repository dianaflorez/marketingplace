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

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("empresa/index"),
    "enableClientValidation" => true,
]);
?>
<?php /*
<div class="form-group">
    <?= $f->field($form, "q")->input("search") ?>
</div>
<?= Html::submitButton("Buscar", ["class" => "btn btn-primary"]) ?>
<?php $f->end() ?>
<h3><?= $search ?></h3>
*/?>

<h3>Lista de Empresas</h3>
<div class="row">
    <?php foreach($model as $row): ?>
     <div class="col-md-4"> 
      <div class="panel panel-default">
        <div class="panel-body">
           <?php $urllogo = Empresainf::findOne(['idemp' => $row->idemp, 'idtipo' =>10]); ?>

        <?php if($urllogo['descripcion']){ ?>
          <?= Html::img($urllogo['descripcion'],["height"=>"70px", "class" => "img-circle"]); ?>
          <br />
        <?php }?> 

          <?= $row->nombre ?><br />
          <?= $row->nit ?>
        </div>
      </div>
      </div>
    <?php endforeach ?>
</div>

