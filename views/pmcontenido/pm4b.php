<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<br />
<div class="row">

<?php foreach($model2 as $pmc): ?>
		<?php if($pmc->titulo == "Estrategia"){  ?>
		
		  	<div class="col-md-10">
			 	<div class="panel panel-warning">
			      <div class="panel-heading"><b><?= $pmc->titulo.$pmc->orden; ?></b></div>
			      <div class="panel-body">
					<p>
					  	<?= $pmc->descripcion; ?>
					  	<br />
				    	<a href="<?= Url::toRoute(["pmcontenido/update", "id" => $pmc->idpmc, "idemp" => $emp->idemp, "activo" => "pm4b"]) ?>">
				       	Editar</a>
					</p>
			      </div>
			    </div>		
			</div>
		<?php }  //Cierre if Objetivo ?>	
</p>
<?php endforeach ?>

	<a class="btn btn-warning" href="<?= Url::toRoute(["pmcontenido/create", 
									"id" 	=> $pm4id, 
									"idemp" => $emp->idemp, 
									"activo" => "pm4b",
									"cont"	=> "Estrategia",
								]) ?>">
   	Agregar Estrategia</a>
</div>


