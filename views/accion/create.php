<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["pmcontenido/index",  "id" => $emp->idemp]) ?>">
	<?php echo "Nueva Accion - ".$emp->nombre; ?>
</a>
</h2>	
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
