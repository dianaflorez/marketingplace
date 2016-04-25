<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pmcontenido */

$this->title = $model->titulo;
//$this->params['breadcrumbs'][] = ['label' => 'Pmcontenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pmcontenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->idpmc,'idemp' =>$pm->idemp, 'activo'=>$activo], ['class' => 'btn btn-primary']) ?>
        
        <? /* Html::a('Delete', ['delete', 'id' => $model->idpmc], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'idpmc',
          //  'idpm',
          //  'titulo',
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
