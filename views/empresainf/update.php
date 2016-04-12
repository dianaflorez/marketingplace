<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Empresainf */

$this->title = 'Actualizar Información '.$modelemp->nombre;;
$this->params['breadcrumbs'][] = ['label' => 'Empresainfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idinf, 'url' => ['view', 'id' => $model->idinf]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="empresainf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipo'	=> $tipo,
        'modelemp'	=> $modelemp,
    ]) ?>

</div>
