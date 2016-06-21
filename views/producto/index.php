<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

$this->title = $emp->nombre.' - Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<a class="btn btn-success" href="<?= Url::toRoute(["producto/create", "id" => $idemp]) ?>">Nuevo Producto</a>
<a class="btn btn-info" href="<?= Url::toRoute(["facturah/index", "idemp" => $idemp]) ?>" > Ventas </a>


<a class="btn btn-info pull-right" style="margin-right: 27px" href="javascript:history.back(1)">Regresar</a>

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
        //    'iva',
            'estado',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
