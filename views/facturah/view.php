<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Facturah */

$this->title = $model->idfh;
$this->params['breadcrumbs'][] = ['label' => 'Facturahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturah-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idfh], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idfh], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idfh',
            'idusu',
            'refpago',
            'prefijo',
            'codigo',
            'totalnormal',
            'totaldes',
            'vlrdes',
            'neto',
            'vlriva',
            'total',
            'estado',
            'tipo',
            'fecha',
            'descripcion',
            'trm',
            'moneda',
            'feccre',
            'fecmod',
            'usumod',
        ],
    ]) ?>

</div>
