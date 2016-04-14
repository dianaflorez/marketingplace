<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $model->idemp]) ?>">
    <?php echo $model->nombre." - ".$nomemp; ?>
</a>
</h2>           
<?php
$this->params['breadcrumbs'][] = "Actualizar";
?>
<div class="planaccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idpa], ['class' => 'btn btn-primary']) ?>
      
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
            'responsable',
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
