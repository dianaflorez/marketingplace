<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $model->idemp]) ?>">
	<?php echo "Editar Accion - ".$emp->nombre; ?>
</a>
</h2>	       	
<?php
$this->params['breadcrumbs'][] = ['label' => 'Accion', 'url' => ['view', 'id' => $model->idaccion]];
//$this->params['breadcrumbs'][] = 'Accion';
?>
<div class="accion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp'   => $emp,
    ]) ?>

</div>
