<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'idusu',
            'nombre1',
          //  'nombre2',
            'apellido1',
           // 'apellido2',
            // 'idtide',
            'identificacion',
            'username',
            // 'clave',
            // 'authkey',
            // 'accesstoken',
            // 'role',
            // 'activo',
            // 'estado',
            // 'idemp',
            // 'feccre',
            // 'fecmod',
            // 'usumod',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
