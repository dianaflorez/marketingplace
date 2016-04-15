<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Elemento */

$this->title = 'Update Elemento: ' . $model->idele;
$this->params['breadcrumbs'][] = ['label' => 'Elementos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idele, 'url' => ['view', 'id' => $model->idele]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="elemento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
