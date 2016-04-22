<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["cliente/index",  "idemp" => $model->idemp, "cliente" => $model->tipo]) ?>">
    <?php echo $emp->nombre." - Vista Cliente ".$model->tipo; ?>
</a>
</h2>           
<?php
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index', 'idemp'=>$model->idemp, 'cliente' => $model->tipo]];
$this->params['breadcrumbs'][] = ['label' => $model->nombre1, 'url' => ['view', 'id' => $model->idcli]];
$this->params['breadcrumbs'][] = 'Vista';
?>
<div class="cliente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idcli], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Desactivar', ['delete', 'id' => $model->idcli], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea desactivar este usuario?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php if($model->tipo == "Institucional") { ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'idcli',
            'nit',
            'nombre1',
         //   'nombre2',
        //  'apellido1',
         //   'apellido2',
         //   'idtide',
         //   'identificacion',
         //   'fecnac',
         //   'genero',
            'tipo',
            'estado',
            'observacion:ntext',
            'feccre',
            'fecmod',
            array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$usumod 
           ),
        ],
    ]) ?>
    <?php }elseif($model->tipo == "Individual"){ ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre1',
         //   'nombre2',
           'apellido1',
         //   'apellido2',
            array('label'=>'Tipo Ide.',
             'type'=>'raw',
             'value'=>$tipoide
           ),
            'identificacion',
            'email',
            'fecnac',
            'genero',
            'tipo',
            'estado',
            'observacion:ntext',
            'feccre',
            'fecmod',
            array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$usumod 
           ),
        ],
    ]) ?>
    <?php }else {?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre1',
         //   'nombre2',
           'apellido1',
         //   'apellido2',
            'email',
            'estado',
            'observacion:ntext',
            'feccre',
            'fecmod',
            array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$usumod 
           ),
        ],
    ]) ?>
    

    <?php } ?>

</div>
