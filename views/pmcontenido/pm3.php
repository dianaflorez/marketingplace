<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<br />
<div class="row">
<?php foreach($model as $pm): ?>
	  <div class="col-md-5">
		 	<div class="panel panel-info">
		      <div class="panel-heading"><b><?= $pm->titulo; ?></b></div>
		      <div class="panel-body">
				<p>
				  	<?= $pm->descripcion; ?>
				  	<br />
			    	<a href="<?= Url::toRoute(["pmcontenido/update", "id" => $pm->idpmc, "idemp" => $emp->idemp, "activo" => "pm3"]) ?>">
			       	Editar</a>
				</p>
		      </div>
		    </div>		
		</div>
<?php endforeach ?>
</div>

