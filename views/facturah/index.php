<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturahs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturah-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Facturah', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idfh',
            'idusu',
            'refpago',
            'prefijo',
            'codigo',
            // 'totalnormal',
            // 'totaldes',
            // 'vlrdes',
            // 'neto',
            // 'vlriva',
            // 'total',
            // 'estado',
            // 'tipo',
            // 'fecha',
            // 'descripcion',
            // 'trm',
            // 'moneda',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
