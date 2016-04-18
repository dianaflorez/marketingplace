<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Productos - '.$emp->nombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<a class="btn btn-success" href="<?= Url::toRoute(["producto/create", "id" => $idemp]) ?>">Nuevo Producto</a>
<a class="btn btn-info" href="<?= Url::toRoute(["facturah/index", "id" => $idemp]) ?>" > Ventas </a>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'idpro',
           // 'idemp',
            'codigo',
            'nombre',
            'descripcion:ntext',
            'vlrsiniva',
            'iva',
            'estado',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
