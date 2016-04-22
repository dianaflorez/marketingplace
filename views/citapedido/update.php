<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Citapedido */

$this->title = 'Update Citapedido: ' . $model->idcita;
$this->params['breadcrumbs'][] = ['label' => 'Citapedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcita, 'url' => ['view', 'id' => $model->idcita]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="citapedido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
