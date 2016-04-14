<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pmcontenido */
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Pmcontenido */
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
