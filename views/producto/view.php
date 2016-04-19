<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["producto/index",  "id" => $model->idemp]) ?>">
    <?php echo $model->nombre." - ".$nomemp; ?>
</a>
</h2>           
<?php
$this->title = $model->nombre;
//$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index'], 'id' => $model->idemp];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->idpro], ['class' => 'btn btn-primary']) ?>
        <?php /*
        <?= Html::a('Delete', ['delete', 'id' => $model->idpro], [
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
         //   'idpro',
          //  'idemp',
            'codigo',
            'nombre',
            'descripcion:ntext',
            'vlrsiniva',
       //     'iva',
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
