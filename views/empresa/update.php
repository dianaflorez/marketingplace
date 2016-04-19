<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = $model->nombre.' - Actualizar';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index', 'msg' => '']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idemp]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="empresa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
          'model' => $model,
   
    ]) ?>

</div>
