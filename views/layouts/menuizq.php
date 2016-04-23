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
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Conóscanos', 'url' => ['/site/about']],
           // ['label' => 'Contact', 'url' => ['/site/contact']],

            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : 
            (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    ' Salir (' . Yii::$app->user->identity->username . ')',
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
                    <a class="col-xs-1 col-sm-12 col-md-12" 
                        href="index.php?r=site%2Fadminemp">
                        <div class="row btnm">
                            <div class="col-xs-12 col-sm-4">
                                <img class="iconos" src="images/suitcase.png">     
                            </div>
                            <div class="menulbl col-sm-8" >
                                Información Empresa
                            </div>
                        </div>
                    </a>
                    
                    <a class="col-xs-1 col-sm-12 col-md-12"  href="">
                         <div class="row btnm" >
                            <div class="col-sm-4">
                                <img class="iconos" src="images/location.png">
                            </div>
                            <div class="menulbl col-sm-8">
                                Plan de Mercadeo
                            </div>
                        </div>
                    </a>
                    
                    <a class="col-xs-1 col-sm-12 col-md-12" href="">
                       <div class="row btnm" >
                            <div class="col-sm-4">
                               <img class="iconos" src="images/calendar.png"> <br />    
                            </div>
                            <div class="menulbl col-sm-8">
                                Plan de Accion
                            </div>
                        </div>
                    </a>
              
                    <a class="col-xs-1 col-sm-12 col-md-12" href="">
                       <div class="row btnm" >
                            <div class="col-sm-4">
                                <img class="iconos" src="images/people.png"> <br />    
                            </div>
                            <div class="menulbl col-sm-8">
                                Gestion de Clientes
                            </div>
                        </div>
                    </a>
             
                    <a class="col-xs-1 col-sm-12 col-md-12" href="">
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
