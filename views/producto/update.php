<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = 'Productos - '.$emp->nombre;;
?>
<h2>
	<a href="<?= Url::toRoute(["producto/index",  "id" => $emp->idemp]) ?>">
	    <?php echo "Editar producto - ".$emp->nombre; ?>
	</a>
</h2>   
<div class="producto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
