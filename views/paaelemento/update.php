<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h3>
<a href="<?= Url::toRoute(["planaccion/index",  "id" => $emp->idemp]) ?>">
	<?php echo $emp->nombre." - Editar Elemento ".$pa; ?>
</a>
</h3>	
<?php
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paaelemento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
