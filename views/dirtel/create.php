<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2>
<a href="<?= Url::toRoute(["cliente/index",  
                                "idemp"  => $emp->idemp,
                                "cliente"=> $cliente,
                                ]) ?>">
	<?php echo $emp->nombre." - ".$cliente; ?>
</a>
</h2>	
<?php

$this->params['breadcrumbs'][] = "Nuevo";
?>
<div class="dirtel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lbl'	=> $lbl,
    ]) ?>

</div>
