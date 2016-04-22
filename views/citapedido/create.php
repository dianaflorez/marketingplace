<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Citapedido */

$this->title = 'Create Citapedido';
$this->params['breadcrumbs'][] = ['label' => 'Citapedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citapedido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
