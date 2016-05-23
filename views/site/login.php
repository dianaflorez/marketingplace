<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Ingresar';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login col-xs-offset-1 col-xs-10 col-sm-offset-4 col-sm-5" align="center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor llene los siguientes campos para ingresar:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
           // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-sm-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Usuario') ?>

        <?= $form->field($model, 'clave')->passwordInput() ?>

<?php /*
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
*/ ?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

            <a class="btn btn-default" href="<?= Url::toRoute(["site/index"]) ?>">Volver</a>

            </div>
            
        </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
       Bienvenido...
    </div>
</div>