<?php

use yii\helpers\Html;

use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $emp->idemp]) ?>">
	<?php echo "Nuevo Plan - ".$emp->nombre; ?>
</a>
</h2>	
<?php
$this->params['breadcrumbs'][] = "Plan de Accion";
?>
<div class="planaccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'estado'=> $estado,
    ]) ?>

</div>
