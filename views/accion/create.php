<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h3>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $emp->idemp]) ?>">
	<?php echo "Nueva Accion - ".$emp->nombre; ?>
</a>
</h3>	
<?php
$this->params['breadcrumbs'][] = "Nueva Accion";
?>
<div class="accion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp'	=> $emp,
    ]) ?>

</div>
