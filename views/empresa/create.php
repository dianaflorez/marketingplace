<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = 'Nueva Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index', 'msg' => '']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
    ]) ?>

</div>
