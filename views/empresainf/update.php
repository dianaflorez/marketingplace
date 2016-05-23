<?php

use yii\helpers\Html;

//$this->title = $modelemp->nombre.' - Actualizar Información ';
//$this->params['breadcrumbs'][] = ['label' => 'Empresainfs', 'url' => ['index','id' => $model->idemp]];
//$this->params['breadcrumbs'][] = ['label' => $model->idinf, 'url' => ['view', 'id' => $model->idinf]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<h3>
<?php
echo $modelemp->nombre.' - Actualizar Información '.$tipo['nombre'];
?>
</h3>
<a class="btn btn-info pull-right" href="javascript:history.back(1)">Regresar</a>
<br />
<div class="empresainf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipo'	=> $tipo,
        'modelemp'	=> $modelemp,
    ]) ?>

</div>
