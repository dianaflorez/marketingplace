<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Facturad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="facturad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idfh')->textInput() ?>

    <?= $form->field($model, 'idpro')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vlr1')->textInput() ?>

    <?= $form->field($model, 'pordes')->textInput() ?>

    <?= $form->field($model, 'vlr2')->textInput() ?>

    <?= $form->field($model, 'descuento')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'poriva')->textInput() ?>

    <?= $form->field($model, 'vlriva')->textInput() ?>

    <?= $form->field($model, 'neto')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'fechaini')->textInput() ?>

    <?= $form->field($model, 'fechamod')->textInput() ?>

    <?= $form->field($model, 'usumod')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
