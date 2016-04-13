<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Planmarketing */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Planmarketings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planmarketing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->idpm], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
         //   'idpm',
             array('label'=>'Empresa',
             'type'=>'raw',
             'value'=>$nomemp
            ),  
            'nombre',
            'descripcion:ntext',
            'feccre',
            'fecmod',
             array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$usumod 
            ),  
        ],
    ]) ?>

</div>
