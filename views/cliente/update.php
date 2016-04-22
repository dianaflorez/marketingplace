<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["cliente/index",  "idemp" => $model->idemp, "cliente" => $model->tipo]) ?>">
	<?php echo $emp->nombre." - Actualizar Cliente ".$cliente; ?>
</a>
</h2>	       	
<?php
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index', 'idemp'=>$model->idemp, 'cliente' => $model->tipo]];
$this->params['breadcrumbs'][] = ['label' => $model->nombre1, 'url' => ['view', 'id' => $model->idcli]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="cliente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipo'	=> $tipo,
        'genero'=> $genero,
        'tide'	=> $tide,
        'estado'=> $estado,
   		'cliente'=> $cliente,
   		'emp'	=> $emp,
    ]) ?>

</div>
