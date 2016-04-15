<?php

use yii\helpers\Html;

use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["cliente/index",  "id" => $emp->idemp]) ?>">
	<?php echo "Nueva Cliente ".$tipo.' - '.$emp->nombre; ?>
</a>
</h2>	
<?php
//$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index'], 'idemp' = $emp->idemp ];
$this->params['breadcrumbs'][] = "Nuevo";
?>
<div class="cliente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipo'	=> $tipo,
        'genero'=> $genero,
        'tide'	=> $tide,
        'estado'=> $estado,
        'emp'	=> $emp,
    ]) ?>

</div>
