<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["planacion/index",  "id" => $emp->idemp]) ?>">
	<?php echo "Nuevo Elemento - ".$emp->nombre; ?>
</a>
</h2>	
<?php
$this->params['breadcrumbs'][] = "Nuevo Elemento";
?>
<div class="elemento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp'	=> $emp,

    ]) ?>

</div>
