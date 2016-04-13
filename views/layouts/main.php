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

    $validarusuario = false;
    if(!Yii::$app->user->isGuest){
        $validarusuario = Yii::$app->user->identity->isSuperMegaAdmin(Yii::$app->user->identity->idusu); 
    }
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'MarketingPlace',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],

//DF      
            [
            'label' => 'Plan Marketing',
            'url' => ['planmarketing/index'],
            'visible' => $validarusuario
            ],                 
            [
            'label' => 'Empresas',
            'url' => ['empresa/index', 'msg' => ''],
            'visible' => $validarusuario
            ],
             [
            'label' => 'Usuarios',
            'url' => ['usuario/index'],
            'visible' => $validarusuario
            ],
            [
            'label' => 'Tipos',
            'url' => ['tipo/index'],
            'visible' => $validarusuario
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
