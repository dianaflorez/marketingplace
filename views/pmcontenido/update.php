<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pmcontenido */

$this->title = 'Update Pmcontenido: ' . $model->idpmc;
$this->params['breadcrumbs'][] = ['label' => 'Pmcontenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpmc, 'url' => ['view', 'id' => $model->idpmc]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="pmcontenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
