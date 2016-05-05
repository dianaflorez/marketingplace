<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<link rel="stylesheet" id="global-css" href="css/generalizq.css" type="text/css" media="all" />

<body>
<?php $this->beginBody() ?>
<?php 
    $role = Yii::$app->user->identity->role; 
    if($role == 2){
        $role = "adminemp";
    }else{
        $role = "comercial";
    }
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logopeq2.png', ['alt'=>Yii::$app->name]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
              ['label' => '', 'url' => ['/site/datos'],'options'=> ['class'=>'imgdatos']],
          //  ['label' => 'Conóscanos', 'url' => ['/site/about']],
           // ['label' => 'Contact', 'url' => ['/site/contact']],

            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : 
            (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    ' '.Html::img('@web/images/iconos/exit.png' ). Yii::$app->user->identity->username . ' ',
                    ['class' => 'btn btn-link ']
                )
                . Html::endForm()
                . '</li>'
            )

        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

<!--MENU-->
 <div class="row" >
            <div class="wellr col-xs-12 col-sm-4 col-md-3" >
                <br />
                    <?php
                        if($role == "adminemp")
                            $urlinicio = "index.php?r=site%2Fadminemp";
                        else
                            $urlinicio = "index.php?r=site%2Fcomercial";
                    ?>

                    <a class="col-xs-1 col-sm-12 col-md-12" 
                        href="<?=$urlinicio?>">
                        <div class="row btnm">
                            <div class="col-xs-12 col-sm-4">
                                <img class="iconos" src="images/suitcase.png">     
                            </div>
                            <div class="menulbl col-sm-8" >
                                Información Empresa
                            </div>
                        </div>
                    </a>


                    <?php $url = "index.php?r=pmcontenido%2Findex&id=".Yii::$app->user->identity->idemp."&activo=pm1" ?>
                    <a class="col-xs-1 col-sm-12 col-md-12"  
                        href="<?=$url?>">
                         <div class="row btnm" >
                            <div class="col-sm-4">
                                <img class="iconos" src="images/location.png">
                            </div>
                            <div class="menulbl col-sm-8">
                                Plan de Mercadeo
                            </div>
                        </div>
                    </a>
                    <?php
                        if($role == "adminemp")
                            $urlpa = "index.php?r=planaccion%2Findex&id=".Yii::$app->user->identity->idemp;
                        else
                            $urlpa = "index.php?r=planaccion%2Fviewplan&id=1&tr=1";
                    ?>
                    
                    <a class="col-xs-1 col-sm-12 col-md-12" 
                        href="<?= $urlpa?>">
                       <div class="row btnm" >
                            <div class="col-sm-4">
                               <img class="iconos" src="images/calendar.png"> <br />    
                            </div>
                            <div class="menulbl col-sm-8">
                                Plan de Accion
                            </div>
                        </div>
                    </a>
              
                    <?php $urlacc = "index.php?r=cliente%2Findex&idemp=".Yii::$app->user->identity->idemp ?>
                    
                    <a class="col-xs-1 col-sm-12 col-md-12" 
                        href="<?=$urlacc?>">
                       <div class="row btnm" >
                            <div class="col-sm-4">
                                <img class="iconos" src="images/people.png"> <br />    
                            </div>
                            <div class="menulbl col-sm-8">
                                Gestion de Clientes
                            </div>
                        </div>
                    </a>
             
             <?php $urlventas = "index.php?r=facturah%2Findex&idemp=".Yii::$app->user->identity->idemp ?>
                    
                    <a class="col-xs-1 col-sm-12 col-md-12" 
                        href="<?= $urlventas?>">
                       <div class="row btnm" >
                            <div class="col-sm-4">
                                <img class="iconos" src="images/coins.png"> <br />    
                            </div>
                            <div class="menulbl col-sm-8">
                                Ventas
                            </div>
                        </div>
                    </a>
             
                    <a class="col-xs-1 col-sm-12 col-md-12" href="">
                       <div class="row btnm" >
                            <div class="col-sm-4">
                                <img class="iconos" src="images/arrow.png"> <br />    
                            </div>
                            <div class="menulbl col-sm-8">
                                Evaluación
                            </div>
                        </div>
                    </a>
                
            </div> <!--FIN menu-->
<!--FIN-->
            <div class="col-xs-12 col-sm-8 col-md-9" >
            
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            &copy;wwww.growthmipymes.com <?= date('Y') ?>
        </p>
        <p class="pull-right"> Desarrollado por <a href="http://www.ideartics.com" target="_blank"> IdearTics </a></p>
       
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
