<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Faccredito */

$this->title = $model->idcre;
$this->params['breadcrumbs'][] = ['label' => 'Faccreditos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faccredito-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idcre], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idcre], [
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
            'idcre',
            'idfh',
            'idemp',
            'totalfh',
            'abono',
            'saldo',
            'feccre',
            'fecmod',
            'usumod',
        ],
    ]) ?>

</div>
