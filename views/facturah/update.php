<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Facturah */

$this->title = 'Update Facturah: ' . $model->idfh;
$this->params['breadcrumbs'][] = ['label' => 'Facturahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idfh, 'url' => ['view', 'id' => $model->idfh]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="facturah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
