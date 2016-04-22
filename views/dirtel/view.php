<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dirtel */

$this->title = $model->iddirtel;
$this->params['breadcrumbs'][] = ['label' => 'Dirtels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dirtel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->iddirtel], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->iddirtel], [
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
           // 'iddirtel',
           // 'idemp',
            'tabla',
            'idtabla',
            'idtipo',
            'dirtel',
            'id_pais',
            'id_dep',
            'id_mun',
            'descripcion',
            'feccre',
            'fecmod',
            'usumod',
        ],
    ]) ?>

</div>
