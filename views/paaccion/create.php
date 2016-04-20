<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h3>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $emp->idemp]) ?>">
	<?php echo $emp->nombre." - Nueva Accion ".$pa; ?>
</a>
</h3>	
<?php
$this->params['breadcrumbs'][] = "Nueva Accion";
?>

<div class="paaccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'estado'=> $estado,

    ]) ?>

</div>
