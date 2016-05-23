<?php

use yii\helpers\Html;

$this->title = 'Información '.$modelemp->nombre;
if(Yii::$app->user->identity->role == 4 || Yii::$app->user->identity->role ==7)
     $this->params['breadcrumbs'][] = ['label' => 'Empresainfs', 'url' => ['index','id'=>$modelemp->idemp]];
elseif(Yii::$app->user->identity->role == 2) 
	$this->params['breadcrumbs'][] = ['label' => 'Empresa', 'url' => ['site/adminemp']];

$this->params['breadcrumbs'][] = $this->title;
?>
<a class="btn btn-info pull-right" href="javascript:history.back(1)">Regresar</a>

<div class="empresainf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelemp'	=> $modelemp,
    ]) ?>

</div>
