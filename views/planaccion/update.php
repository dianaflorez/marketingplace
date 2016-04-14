<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $emp->idemp]) ?>">
	<?php echo $model->nombre." - ".$emp->nombre; ?>
</a>
</h2>	       	
<?php
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idpa]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="planaccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'estado'=> $estado,
    ]) ?>

</div>
