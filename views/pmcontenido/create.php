<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pmcontenido */

$this->title = 'Create Pmcontenido';
$this->params['breadcrumbs'][] = ['label' => 'Pmcontenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pmcontenido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
