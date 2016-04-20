<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $model->idemp]) ?>">
    <?php echo $emp->nombre." - Accion"; ?>
</a>
</h2>           
<?php
$this->params['breadcrumbs'][] = ['label' => 'Accion', 'url' => ['view', 'id' => $model->idaccion]];
$this->params['breadcrumbs'][] = 'Vista';
?>

<div class="paaccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->idaccion], ['class' => 'btn btn-primary']) ?>
        <?php /*
        <?= Html::a('Delete', ['delete', 'id' => $model->idaccion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'idaccion',
          // 'idemp',
          //  'idpa',
            'descripcion:ntext',
            'orden',
            'fecini',
            'fecfin',
            'responsable:ntext',
            'costo',
            'estado',
            'feccre',
            'fecmod',
             array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$usumod 
            ),
        ],
    ]) ?>

</div>
