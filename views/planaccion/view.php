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
      
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            array('label'=>'Empresa',
             'type'=>'raw',
             'value'=>$nomemp 
            ),
            'nombre',
            'fecini',
            'fecfin',
            'idresponsable',
            'idelemento',
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
