<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Planaccion */

$this->title = $model->idpa;
$this->params['breadcrumbs'][] = ['label' => 'Planaccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planaccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idpa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idpa], [
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
            'idpa',
            'idemp',
            'nombre',
            'fecini',
            'fecfin',
            'idresponsable',
            'idelemento',
            'costo',
            'estado',
            'feccre',
            'fecmod',
            'usumod',
        ],
    ]) ?>

</div>
