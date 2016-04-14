<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Planaccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planaccion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->datepickerRow($model, 'fecini')->textInput() ?>

    <?= $form->field($model, 'fecfin')->textInput() ?>

    <?= $form->field($model, 'responsable')->textInput() ?>

    <?= $form->field($model, 'costo')->textInput() ?>

    <?php echo $form->field($model, 'estado')->dropDownList($estado); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
