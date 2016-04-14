<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contenidos';
$this->params['breadcrumbs'][] = $this->title;

echo "<h3>Plan Marketing ".$emp->nombre."</h3>";

$form = ActiveForm::begin(['id' => 'contact-form']); 

$sw1 = false; 
$sw2 = false; 
$sw3 = false; 
$sw4 = false; 
$sw4a = false; 
$sw4b = false; 

if($activo == "pm1") {
    $sw1 = true;
}elseif($activo == "pm2") {
    $sw2 = true;
}elseif($activo == "pm3") {
    $sw3 = true;
}elseif($activo == "pm4a") {
    $sw4a = true;
    $sw4  = true;
}elseif($activo == "pm4b") {
    $sw4  = true;
    $sw4b = true;
}

echo Tabs::widget([
    'items' => [
        [
            'label' => 'Analisis Situacion Externa',
            'content' => $this->render('pm1',['model' => $pm1]),
            'active' => $sw1
        ],
        [
            'label' => 'Analisis Situacion Interna',
            'content' => $this->render('pm2',['model' => $pm2]),
          //  'headerOptions' => [...],
            'options' => ['id' => 'myveryownID'],
            'active' => $sw2
        ],
        [
            'label' => 'Diagnostico de la Situacion',
            'content' => $this->render('pm3',['model' => $pm3, 'emp' => $emp]),
            'active' => $sw3 
        ],
        [
            'label' => 'Desiciones Estrategicas',
            'items' => [
                 [
                    'label' => 'Objetivos de Marketing', 
                    'content' => $this->render('pm4a',['model2' => $pm4, 'emp' => $emp]),
                    'active' => $sw4a,
                 ],
                 [
                    'label' => 'Estrategicas de Marketing',
                    'content' => $this->render('pm4b',['model2' => $pm4, 'emp' => $emp]),
                    'active' => $sw4b,
                 ],
            ],
            'active' => $sw4,
        ],
    ],
]);

ActiveForm::end(); 