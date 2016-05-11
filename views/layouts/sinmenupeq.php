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

<link rel="stylesheet" id="global-css" href="css/gensinmenupeq.css" type="text/css" media="all" />

<body>
<?php $this->beginBody() ?>

<?php

    $validarusuario = false;
    if(!Yii::$app->user->isGuest){
        $validarusuario = Yii::$app->user->identity->isSuperMegaAdmin(Yii::$app->user->identity->idusu); 
    }
?>

<div class="wrap">
    <div class="container">
        <img class="logo" src="images/logopeq.png">

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container" align="center" >
        <p >
            &copy;wwww.growthmipymes.com <?= date('Y') ?>
            <br />
            Desarrollado por <a href="http://www.ideartics.com" target="_blank"> IdearTics </a>
    
        </p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
