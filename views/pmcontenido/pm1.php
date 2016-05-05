<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<br />
<div class="panel panel-default">
<div class="panel-heading">Analisis Situación Externa</div>
  <div class="panel-body">

	<?= $model->descripcion; ?>
		<p>
		    <a href="<?= Url::toRoute(["planmarketing/update", "id" => $model->idpm]) ?>">
		       Editar</a>
		</p>
	</div>
</div>		
	

