<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Citapedido */

$this->title = $model->idcita;
$this->params['breadcrumbs'][] = ['label' => 'Citapedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citapedido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idcita], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idcita], [
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
            'idpedido',
            'idemp',
            'idcita',
            'pedido:ntext',
            'cant',
            'feccre',
            'fecmod',
            'usumod',
        ],
    ]) ?>

</div>
