<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pmcontenidos';
$this->params['breadcrumbs'][] = $this->title;


$form = ActiveForm::begin(['id' => 'contact-form']); 

echo Tabs::widget([
    'items' => [
        [
            'label' => 'Analisis Situacion Externa',
            'content' => $this->render('pm1',['model' => $pm1]),
            'active' => true
        ],
        [
            'label' => 'Analisis Situacion Interna',
            'content' => $this->render('pm2',['model' => $pm2]),
          //  'headerOptions' => [...],
            'options' => ['id' => 'myveryownID'],
        ],
        [
            'label' => 'Diagnostico de la Situacion',
            'content' => $this->render('pm3',['model' => $pm3]),
        ],
        [
            'label' => 'Desiciones Estrategicas',
            'items' => [
                 [
                     'label' => 'Objetivos de Marketing',
                     'content' => '...',
                 ],
                 [
                     'label' => 'Estrategicas de Marketing',
                     'content' => 'DropdownB, Anim pariatur cliche...',
                 ],
            ],
        ],
    ],
]);

ActiveForm::end(); 