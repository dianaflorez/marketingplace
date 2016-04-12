<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Planmarketing */

$this->title = 'Create Planmarketing';
$this->params['breadcrumbs'][] = ['label' => 'Planmarketings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planmarketing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
