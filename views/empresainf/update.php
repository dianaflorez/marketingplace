<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Empresainf */

$this->title = $modelemp->nombre.' - Actualizar Información ';
$this->params['breadcrumbs'][] = ['label' => 'Empresainfs', 'url' => ['index','id' => $model->idemp]];
//$this->params['breadcrumbs'][] = ['label' => $model->idinf, 'url' => ['view', 'id' => $model->idinf]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="empresainf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipo'	=> $tipo,
        'modelemp'	=> $modelemp,
    ]) ?>

</div>
