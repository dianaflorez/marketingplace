<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Faccredito */

$this->title = 'Realizar Abono';
$this->params['breadcrumbs'][] = ['label' => 'Faccreditos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faccredito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'abonoant' => $abonoant,

    ]) ?>

</div>
