<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Empresainf */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresainf-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // echo $form->field($model, 'idtipo')->dropDownList($tipo); ?>

    <?= $form->field($model, 'inf')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nueva' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
