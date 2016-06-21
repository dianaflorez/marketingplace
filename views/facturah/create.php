<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["facturah/index",  "idemp" => $emp->idemp]) ?>">
	<?php echo $emp->nombre." - Nueva Venta"; ?>
</a>
</h2>	
<?php
$this->params['breadcrumbs'][] = $emp->nombre." - Nueva Venta"; 
?>
<div class="facturah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
        'modelfd'   => $modelfd,
        'modelcredito'	=> $modelcredito,
        'emp'		=> $emp,
        'clientes'	=> $clientes,
        'productos' => $productos,
        'tipo'		=> $tipo,
        'facturad'  => $facturad,
        'data'      => $data,
        'msg'       => $msg,
    ]) ?>

</div>
