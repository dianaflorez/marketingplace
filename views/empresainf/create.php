<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Empresainf */

$this->title = 'Información '.$modelemp->nombre;;
$this->params['breadcrumbs'][] = ['label' => 'Empresainfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="empresainf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipo'	=> $tipo,
        'modelemp'	=> $modelemp,
    ]) ?>

</div>
