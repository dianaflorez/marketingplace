<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Pmcontenido */
?>
<h2>
<a href="<?= Url::toRoute(["pmcontenido/index",  "id" => $emp->idemp, "activo" => $tab]) ?>">
	<?php echo $model->titulo." - ".$emp->nombre; ?>
</a>
</h2>	       	
<?php
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['view', 'id' => $model->idpmc, "activo" => $tab]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="pmcontenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
