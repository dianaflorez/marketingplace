<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $model->idemp]) ?>">
    <?php echo "Accion - ".$nomemp; ?>
</a>
</h2>           
<?php
$this->params['breadcrumbs'][] = "Accion";
?>
<div class="accion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->idaccion], ['class' => 'btn btn-primary']) ?>
      
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'idaccion',
            array('label'=>'Empresa',
             'type'=>'raw',
             'value'=>$nomemp 
            ),
        
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
