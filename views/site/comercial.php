<?php 
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $modelemp->nombre;
?>
<div class="empresainf-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php   echo "nit. ".$modelemp->nit; ?>
    <br /><br />
   
   <?php foreach($model as $row): ?>

    <div class="panel panel-default">
      <div class="panel-heading"><?= $row->idtipo0->nombre ?></div>
      <div class="panel-body">
        <?= $row->inf ?>
        <br /><br />
           
      </div>
    </div>

    <?php endforeach ?>

</div>
