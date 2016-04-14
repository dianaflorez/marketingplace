<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<br />
<div class="row">
<?php foreach($model as $pm): ?>
	 <?php foreach($pm->pmcontenidos as $pmc): ?>

	
	  <div class="col-md-5">
		 	<div class="panel panel-info">
		      <div class="panel-heading"><b><?= $pmc->titulo; ?></b></div>
		      <div class="panel-body">
				<p>
				  	<?= $pmc->descripcion; ?>
				  	<br />
			    	<a href="<?= Url::toRoute(["pmcontenido/update", "id" => $pmc->idpmc, "idemp" => $emp->idemp, "activo" => "pm3"]) ?>">
			       	Editar</a>
				</p>
		      </div>
		    </div>		
		</div>
	
	<?php endforeach ?>
<?php endforeach ?>
</div>

