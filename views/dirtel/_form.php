<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dirtel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dirtel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dirtel')->textInput(['maxlength' => true])->label($lbl) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nuevo' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
