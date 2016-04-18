<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Facturad */

$this->title = 'Update Facturad: ' . $model->idfd;
$this->params['breadcrumbs'][] = ['label' => 'Facturads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idfd, 'url' => ['view', 'id' => $model->idfd]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="facturad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
