<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<br />
<div class="row">

<?php foreach($model2 as $pm): ?>
	 <?php foreach($pm->pmcontenidos as $pmc): ?>

		<?php if($pmc->titulo == "Objetivo"){  ?>
	
		  	<div class="col-md-5">
			 	<div class="panel panel-warning">
			      <div class="panel-heading"><b><?= $pmc->titulo; ?></b></div>
			      <div class="panel-body">
					<p>
					  	<?= $pmc->descripcion; ?>
					  	<br />
				    	<a href="<?= Url::toRoute(["pmcontenido/update", "id" => $pmc->idpmc, "idemp" => $emp->idemp, "activo" => "pm4a"]) ?>">
				       	Editar</a>
					</p>
			      </div>
			    </div>		
			</div>
		<?php } //Fin if obj ?>
		
	<?php endforeach ?>	
<br />
	<a class="btn btn-warning" href="<?= Url::toRoute(["pmcontenido/create", 
									"id" 	=> $pm->idpm, 
									"idemp" => $emp->idemp, 
									"activo" => "pm4a",
									"cont"	=> "Objetivo",
								]) ?>">
   	Agregar Objetivo</a>
</p>
<?php endforeach ?>
</div>


