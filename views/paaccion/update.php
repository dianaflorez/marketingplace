<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $model->idemp]) ?>">
	<?php echo $emp->nombre." - Editar Accion"; ?>
</a>
</h2>	       	
<?php
$this->params['breadcrumbs'][] = ['label' => 'Accion', 'url' => ['view', 'id' => $model->idaccion]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="paaccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'estado'=> $estado,
    ]) ?>

</div>
