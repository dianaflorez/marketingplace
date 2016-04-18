<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Facturad */

$this->title = $model->idfd;
$this->params['breadcrumbs'][] = ['label' => 'Facturads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facturad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idfd], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idfd], [
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
            'idfd',
            'idfh',
            'idpro',
            'descripcion:ntext',
            'vlr1',
            'pordes',
            'vlr2',
            'descuento',
            'qty',
            'valor',
            'poriva',
            'vlriva',
            'neto',
            'total',
            'fechaini',
            'fechamod',
            'usumod',
        ],
    ]) ?>

</div>
