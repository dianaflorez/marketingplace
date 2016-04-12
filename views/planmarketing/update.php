<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Planmarketing */

$this->title = 'Update Planmarketing: ' . $model->idpm;
$this->params['breadcrumbs'][] = ['label' => 'Planmarketings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpm, 'url' => ['view', 'id' => $model->idpm]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="planmarketing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
