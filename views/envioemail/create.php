<?php

use yii\helpers\Html;
use yii\helpers\Url;

//Pagination
use yii\widgets\LinkPager;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

$title = $emp->nombre.' - Envio Email';
$this->params['breadcrumbs'][] = $title;

?>

<h2>
<a href="<?= Url::toRoute(["cliente/index",  "idemp" => $emp->idemp]) ?>">
    <?php echo $emp->nombre." - Envio Email"; ?>
</a>
</h2>   

<div class="envioemail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'  => $data,
        'emp'   => $emp,
        'msg' 	=> $msg,
    ]) ?>

</div>
