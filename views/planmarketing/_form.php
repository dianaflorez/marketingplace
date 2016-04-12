<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Planmarketing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planmarketing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idemp')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'feccre')->textInput() ?>

    <?= $form->field($model, 'fecmod')->textInput() ?>

    <?= $form->field($model, 'usumod')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
