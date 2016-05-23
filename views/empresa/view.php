<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = $model->nombre;
//$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idemp], ['class' => 'btn btn-primary']) ?>
<a class="btn btn-info pull-right" href="javascript:history.back(1)">Regresar</a>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'idemp',
            'nombre',
            'nit',
            'feccre',
            'fecmod',
            array('label'=>'Quien Modifico',
             'type'=>'raw',
             'value'=>$usumod 
            ),  
        ],
    ]) ?>

</div>
