<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dirtels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dirtel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dirtel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'iddirtel',
            'idemp',
            'tabla',
            'idtabla',
            'idtipo',
            // 'dirtel',
            // 'id_pais',
            // 'id_dep',
            // 'id_mun',
            // 'descripcion',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
