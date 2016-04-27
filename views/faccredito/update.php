<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Faccredito */

$this->title = 'Update Faccredito: ' . $model->idcre;
$this->params['breadcrumbs'][] = ['label' => 'Faccreditos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcre, 'url' => ['view', 'id' => $model->idcre]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faccredito-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
