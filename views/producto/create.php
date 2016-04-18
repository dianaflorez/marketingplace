<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = 'Productos - '.$emp->nombre;;
?>
<h2>
	<a href="<?= Url::toRoute(["producto/index",  "id" => $emp->idemp]) ?>">
	    <?php echo "Nuevo producto - ".$emp->nombre; ?>
	</a>
</h2>   
<?php
//$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp'	=> $emp,
    ]) ?>

</div>
