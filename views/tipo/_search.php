<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TipoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idtipo') ?>

    <?= $form->field($model, 'tabla') ?>

    <?= $form->field($model, 'orden') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'feccre') ?>

    <?php // echo $form->field($model, 'fecmod') ?>

    <?php // echo $form->field($model, 'usumod') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
