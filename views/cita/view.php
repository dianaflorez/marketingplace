<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["cita/index",  "idemp" => $model->idemp]) ?>">
    <?php echo $emp->nombre." - Vista Cita"; ?>
</a>
</h2>           
<?php
$this->title = "Cita";
$this->params['breadcrumbs'][] = ['label' => 'Citas', 'url' => ['index','idemp' => $emp->idemp]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cita-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->idcita, 'idemp' => $emp->idemp], ['class' => 'btn btn-primary']) ?>
      <?php /*?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idcita], [
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
           // 'idcita',
            array('label'=>'Cliente',
             'type'=>'raw',
             'value'=>$nomcli 
            ),
            'fecha',
            'hora',
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

</div>
