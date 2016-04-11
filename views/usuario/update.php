<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Update Usuario: ' . $model->idusu;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idusu, 'url' => ['view', 'id' => $model->idusu]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model' => $model,
        'msg'  	=> $msg,
        'tipo' 	=> $tipo,
        'emp'	=> $emp,
        'role' 	=> $role,
    ]) ?>

</div>
