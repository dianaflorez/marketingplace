<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["pmcontenido/index",  "id" => $emp->idemp, "activo" => $tab]) ?>">
	<?php echo "Crear ".$cont." - ".$emp->nombre; ?>
</a>
</h2>	
<?php
//$this->params['breadcrumbs'][] = ['label' => 'Pmcontenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $cont;
?>
<div class="pmcontenido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
