<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facturads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Facturad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idfd',
            'idfh',
            'idpro',
            'descripcion:ntext',
            'vlr1',
            // 'pordes',
            // 'vlr2',
            // 'descuento',
            // 'qty',
            // 'valor',
            // 'poriva',
            // 'vlriva',
            // 'neto',
            // 'total',
            // 'fechaini',
            // 'fechamod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
