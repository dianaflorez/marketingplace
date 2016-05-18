<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Envioemail */

$title = $emp->nombre.' - Envio Email';
$this->params['breadcrumbs'][] = $title;
?>

<h2>
<a href="<?= Url::toRoute(["envioemail/create",  "id" => $emp->idemp]) ?>">
    <?php echo $emp->nombre." - Envio Email"; ?>
</a>
</h2>   

<div class="envioemail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha',
            'email:ntext',
            'asunto',
            'contenido:ntext',
        ],
    ]) ?>

</div>
