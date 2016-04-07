<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idusu') ?>

    <?= $form->field($model, 'nombre1') ?>

    <?= $form->field($model, 'nombre2') ?>

    <?= $form->field($model, 'apellido1') ?>

    <?= $form->field($model, 'apellido2') ?>

    <?php // echo $form->field($model, 'idtide') ?>

    <?php // echo $form->field($model, 'identificacion') ?>

    <?php // echo $form->field($model, 'login') ?>

    <?php // echo $form->field($model, 'clave') ?>

    <?php // echo $form->field($model, 'authkey') ?>

    <?php // echo $form->field($model, 'accesstoken') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'idemp') ?>

    <?php // echo $form->field($model, 'feccre') ?>

    <?php // echo $form->field($model, 'fecmod') ?>

    <?php // echo $form->field($model, 'usumod') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
