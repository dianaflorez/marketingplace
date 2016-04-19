<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresainf */

$this->title = $model->idinf;
$this->params['breadcrumbs'][] = ['label' => 'Empresainfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresainf-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idinf], ['class' => 'btn btn-primary']) ?>
     </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idinf',
            'idemp',
            'idtipo',
            'inf:ntext',
            'descripcion:ntext',
            'feccre',
            'fecmod',
            'usumod',
        ],
    ]) ?>

</div>
