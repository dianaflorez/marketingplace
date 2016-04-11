<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresainfs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresainf-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Empresainf', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idinf',
            'idemp',
            'idtipo',
            'inf:ntext',
            'descripcion:ntext',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
