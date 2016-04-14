<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Planaccion */

$this->title = 'Update Planaccion: ' . $model->idpa;
$this->params['breadcrumbs'][] = ['label' => 'Planaccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpa, 'url' => ['view', 'id' => $model->idpa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="planaccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
