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

<link rel="stylesheet" id="global-css" href="css/general.css" type="text/css" media="all" />

<body>
<?php $this->beginBody() ?>

<?php

    $validarusuario  = false;
    $validaremp      = false;
    $validartipo     = false;
    $superMegaAdmin  = false;
    $superadmin      = false;
    $adminemp        = false;   
    $comercio        = false;   
    $ae_inicio       = false;   

    if(!Yii::$app->user->isGuest){
        $superMegaAdmin = Yii::$app->user->identity->isSuperMegaAdmin(Yii::$app->user->identity->idusu); 
  
        $superadmin     = Yii::$app->user->identity->isSuperAdmin(Yii::$app->user->identity->idusu);

        $adminemp     = Yii::$app->user->identity->isAdminEmp(Yii::$app->user->identity->idusu);

        $comercial    = Yii::$app->user->identity->isComercial(Yii::$app->user->identity->idusu);


        if($superMegaAdmin){
            $validaremp     = true;
            $validarusuario = true;
            $validartipo    = true;
        } elseif($superadmin){
            $validaremp     = true;
            $validarusuario = true;
            
        }elseif ($adminemp) {
            $ae_inicio = true;
        }elseif ($comercial){
            $com_inicio = true;
        }
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
              ['label' => 'Home', 'url' => ['/site/index'],'visible' => $validartipo],
              ['label' => 'About', 'url' => ['/site/about'],'visible' => $validartipo],
           // ['label' => 'Contact', 'url' => ['/site/contact']],

            [
            'label' => 'Inicio',
            'url' => ['site/adminemp'],
            'visible' => $ae_inicio
            ],

            [
            'label' => 'Inicio',
            'url' => ['site/comercial'],
            'visible' => $com_inicio
            ],

//DF      
            [
            'label' => 'Empresas',
            'url' => ['empresa/index', 'msg' => ''],
            'visible' => $validaremp
            ],
             [
            'label' => 'Usuarios',
            'url' => ['usuario/index'],
            'visible' => $validarusuario
            ],
            [
            'label' => 'Tipos',
            'url' => ['tipo/index'],
            'visible' => $validartipo
            ],
         

//DFend
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : 
            (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
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
        <?= $content ?>
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
