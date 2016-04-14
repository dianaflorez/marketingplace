<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Accion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accion-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nueva' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
