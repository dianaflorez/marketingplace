<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Envioemail */

$this->title = 'Update Envioemail: ' . $model->idenv;
$this->params['breadcrumbs'][] = ['label' => 'Envioemails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idenv, 'url' => ['view', 'id' => $model->idenv]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="envioemail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
