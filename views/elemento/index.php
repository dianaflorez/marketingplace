<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Elementos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elemento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Elemento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idele',
            'idemp',
            'idpa',
            'descripcion:ntext',
            'orden',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
