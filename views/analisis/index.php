<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

$this->title = 'Analisis';
$this->params['breadcrumbs'][] = $this->title;
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

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("empresa/index"),
    "enableClientValidation" => true,
]);
?>

<h3>Ventas</h3>

<a class="btn btn-info" href="<?= Url::toRoute(["analisis/mercadeo", "idemp" => $emp->idemp]) ?>">Mercadeo</a>





