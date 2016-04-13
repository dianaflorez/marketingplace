<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
...
<?php foreach($model as $row): ?>

   	<h3>...<?= $model->descripcion; ?></h3>
	<p>
    	<a href="<?= Url::toRoute(["planmarketing/update", "id" => $model->idpm]) ?>">
       	Editar</a>
	</p>
<?php endforeach ?>
	

