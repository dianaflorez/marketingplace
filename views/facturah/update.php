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
$this->params['breadcrumbs'][] = $emp->nombre." - Nueva Venta agregando productos"; 
?>
<div class="facturah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        	'model' => $model,
            'modelfd'   => $modelfd,
            'clientes'  => $clientes,
            'emp'       => $emp,
            'productos' => $productos,
            'tipo'      => $tipo,
            'facturad'	=> $facturad,
    ]) ?>

</div>
