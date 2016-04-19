<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */

$this->title = 'Actualizar Cliente: ' . $model->tipo.' - '.$model->idemp ;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcli, 'url' => ['view', 'id' => $model->idcli]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cliente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipo'	=> $tipo,
        'genero'=> $genero,
        'tide'	=> $tide,
        'estado'=> $estado,
   		'cliente'=> $cliente,
    ]) ?>

</div>
