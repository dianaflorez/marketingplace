<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Elemento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elemento-form">

    <?php $form = ActiveForm::begin(); ?>
   
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nuevo' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
