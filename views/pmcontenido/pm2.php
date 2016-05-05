<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<br />
<div class="panel panel-default">
	<div class="panel-heading">Analisis Situación Interna</div>
	<div class="panel-body">
		<?= $model->descripcion; ?>
		<!--Si el usuario es Comercial no mostrar -->
		<?php if (Yii::$app->user->identity->role != 1){ ?>

			<p>
			    <a href="<?= Url::toRoute(["planmarketing/update", "id" => $model->idpm]) ?>">
			       Editar</a>
			</p>
		<?php } ?>	
	</div>	
</div>
	

