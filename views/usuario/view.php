<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->nombre1.' '.$model->nombre2.' '.$model->apellido1.' '.$model->apellido2;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idusu], ['class' => 'btn btn-primary']) ?>
      <?php /*
        <?= Html::a('Delete', ['delete', 'id' => $model->idusu], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        */ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idusu',
            'nombre1',
            'nombre2',
            'apellido1',
            'apellido2',
            array('label'=>'Tipo Iden.',
             'type'=>'raw',
             'value'=>$tide
            ), 
            'identificacion',
            'username',
          //  'clave',
          //  'authkey',
          //  'accesstoken',
            array('label'=>'Role',
             'type'=>'raw',
             'value'=>$role
            ),  
          //  'activate',
            'estado',
            array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$nomemp
            ), 
            'feccre',
            'fecmod',
            array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$usumod 
            ), 
        ],
    ]) ?>

</div>
