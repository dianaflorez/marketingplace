<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//Para autocomplete
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Envioemail */
/* @var $form yii\widgets\ActiveForm */
?>

<h3>
<?php if($msg){ 
        echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $msg,
        ]);
    }
?>
</h3>

<div class="envioemail-form">

    <?php $form = ActiveForm::begin(); ?>

<label class="control-label">Buscar Cliente</label>
        <br />
        <?php
        echo AutoComplete::widget([    
        'class'=>'form-control',
        'clientOptions' => [
        'class'=>'form-control',
        'source'    => $data,
        'minLength' => '3', 
        'autoFill'  => true,
        'select'    => new JsExpression("function( event, ui ) {
                        $('#cliente_id').val(ui.item.id);//#cliente_id is the id of hiddenInput.
                        $('#nombre_id').val(ui.item.email);
                        $('#envioemail-idcli').val( ui.item.id );
                        $('#envioemail-email').val( ui.item.email );
                     }")],
                     ]);
                ?>
        <input type="hidden" name="cliente_id" id="cliente_id" />
        <b><input type="text" name="nombre_id" id="nombre_id" style="border-width:0; width: 200px" readonly />
        </b>
         <?php echo $form->field($model, 'idcli')->hiddenInput()->label(false);?>

    <?= $form->field($model, 'email')->hiddenInput(['readonly' => true])->label(false) ?>

    <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contenido')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Enviar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
