<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<br />
<div class="row">

<?php foreach($model2 as $pmc): ?>
	<?php if($pmc->titulo == "Objetivo"){  ?>
	
		  	<div class="col-md-10">
			 	<div class="panel panel-warning">
			      <div class="panel-heading"><b><?= $pmc->titulo.' '.$pmc->orden; ?></b></div>
			      <div class="panel-body">
					<p>
					  	<?= $pmc->descripcion; ?>
					  	<br />
					  	<!--Si el usuario es Comercial no mostrar -->
						<?php if (Yii::$app->user->identity->role != 1){ ?>

					    	<a href="<?= Url::toRoute(["pmcontenido/update", "id" => $pmc->idpmc, "idemp" => $emp->idemp, "activo" => "pm4a"]) ?>">
					       	Editar</a>
					    <?php } ?>   	
					</p>
			      </div>
			    </div>		
			</div>
		<?php } //Fin if obj ?>
		
<?php endforeach ?>
<!--Si el usuario es Comercial no mostrar -->
<?php if (Yii::$app->user->identity->role != 1){ ?>

	<br />
		<a class="btn btn-warning" href="<?= Url::toRoute(["pmcontenido/create", 
										"id" 	=> $pm4id, 
										"idemp" => $emp->idemp, 
										"activo" => "pm4a",
										"cont"	=> "Objetivo",
									]) ?>">
	   	Agregar Objetivo</a>
<?php } ?>
</p>
</div>


