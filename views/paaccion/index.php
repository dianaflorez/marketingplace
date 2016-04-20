<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paaccions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paaccion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Paaccion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idaccion',
            'idemp',
            'idpa',
            'descripcion:ntext',
            'orden',
            // 'fecini',
            // 'fecfin',
            // 'responsable:ntext',
            // 'costo',
            // 'estado',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
