<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["cita/index",  
                                "idemp"  => $emp->idemp
                                ]) ?>">
	<?php echo $emp->nombre." - Nueva Cita "; ?>
</a>
</h2>	
<?php
$this->params['breadcrumbs'][] = ['label' => 'Citas', 'url' => ['index', 
																'idemp' => $emp->idemp]];
$this->params['breadcrumbs'][] = "Nuevo";
?>

<div class="cita-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'emp'	=> $emp,
        'estado'=> $estado,
        'data' =>  $data,
    ]) ?>

</div>
