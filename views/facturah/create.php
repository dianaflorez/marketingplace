<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Facturah */

$this->title = 'Create Facturah';
$this->params['breadcrumbs'][] = ['label' => 'Facturahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
