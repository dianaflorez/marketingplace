<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["cita/index",  "idemp" => $model->idemp]) ?>">
	<?php echo $emp->nombre." - Editar Cita "; ?>
</a>
</h2>	       	
<?php
//$this->title = 'Update Cita: ' . $model->idcita;
$this->params['breadcrumbs'][] = ['label' => 'Citas', 'url' => ['index','idemp' => $emp->idemp]];
$this->params['breadcrumbs'][] = ['label' => 'Vista', 'url' => ['view', 'id' => $model->idcita]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="cita-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
        'estado'	=> $estado,
        'emp'		=> $emp,
        'data'      => $data,
        'cliente'	=> $cliente,
    ]) ?>

</div>
