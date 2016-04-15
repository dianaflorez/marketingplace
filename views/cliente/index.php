<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>
<?php if($msg){ 
        echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $msg,
        ]);
    }
?>
</h3>
<a class="btn btn-success" href="<?= Url::toRoute(["cliente/create", "id" => $emp->idemp]) ?>">Nuevo Cliente</a>

<a class="btn btn-info" href="<?= Url::toRoute(["cliente/index", "id" => $emp->idemp]) ?>">Clientes Individuales</a>
<a class="btn btn-info" href="<?= Url::toRoute(["cliente/index", "id" => $emp->idemp]) ?>">Clientes Esporadicos</a>


<div class="cliente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cliente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idcli',
            'nit',
            'nombre1',
            'nombre2',
            'apellido1',
            // 'apellido2',
            // 'idtide',
            // 'identificacion',
            // 'fecnac',
            // 'genero',
            // 'tipo',
            // 'estado',
            // 'observacion:ntext',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
