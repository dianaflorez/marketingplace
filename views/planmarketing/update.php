<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Planmarketing */

?>
<h2>
<a href="<?= Url::toRoute(["pmcontenido/index",  "id" => $model->idemp, "activo" => $tab]) ?>">
	<?php echo $model->nombre." - ".$emp->nombre; ?>
</a>
</h2>
<?php
//$this->title = $model->nombre;
//$this->params['breadcrumbs'][] = ['label' => 'Planmarketings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpm, 'url' => ['view', 'id' => $model->idpm]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="planmarketing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
