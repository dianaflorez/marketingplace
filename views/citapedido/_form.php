<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Citapedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citapedido-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'pedido')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cant')->textInput() ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nuevo' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
