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

    <?= $form->field($model, 'inf')->textarea(['rows' => 1])->label('Asunto') ?>

<?php $lbl = "Descripcion"; if($model->idtipo >7) $lbl = "link"; ?>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 1])->label($lbl) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Nueva' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
