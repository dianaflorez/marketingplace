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
    <link rel="stylesheet" type="text/css" href="css/general.css">
</head>

<body>
<?php $this->beginBody() ?>

<?php

    $validarusuario  = false;
    $validaremp      = false;
    $validartipo     = false;
    $superMegaAdmin  = false;
    $superadmin      = false;
    $adminemp        = false;   
    $comercial        = false;   
    $ae_inicio       = false;
    $com_inicio      = false;   

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
<?php 
    $role = Yii::$app->user->identity->role; 
    if($role == 2){
        $role = "adminemp";
    }else{
        $role = "comercial";
    }
?>

<div class="wrap">

<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
 
  <div class="container">
   <div class="navbar-header navbar-left pull-left">
     
      <ul class="nav navbar-nav navbar-left">

        <li class="dropdown pull-left">
          <a href="#" data-toggle="dropdown" style="color:#777; margin-top: -15px;" class="dropdown-toggle">
            <?= Html::img('@web/images/logopeq77.png') ?>
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu menuazul">
           
<!--MENU-->
 <div class="row" >
            <div class="wellr col-xs-10 col-sm-12 col-md-12" >
                    <?php
                        if($role == "adminemp")
                            $urlinicio = "index.php?r=site%2Fadminemp";
                        else
                            $urlinicio = "index.php?r=site%2Fcomercial";
                    ?>

                    <a href="<?=$urlinicio?>">
                        <table >
                            <tr>
                            <td>
                              <img class="iconosd" src="images/suitcasemenu.png">     
                            </td>
                            <td align="center">
                                Información Empresa
                            </tr>    
                        </table>   
                    </a>
                   
                    <?php $url = "index.php?r=pmcontenido%2Findex&id=".Yii::$app->user->identity->idemp."&activo=pm1" ?>

                     <a href="<?=$url?>">
                        <table >
                            <tr>
                            <td>
                              <img class="iconosd" src="images/locationmenu.png">     
                            </td>
                            <td align="center">
                                Plan de Marketing
                            </tr>    
                        </table>   
                    </a>

                    <?php
                        if($role == "adminemp")
                            $urlpa = "index.php?r=planaccion%2Findex&id=".Yii::$app->user->identity->idemp;
                        else
                            $urlpa = "index.php?r=planaccion%2Fviewplan&id=1&tr=1";
                    ?>
                     <a href="<?=$urlpa?>">
                        <table >
                            <tr>
                            <td>
                              <img class="iconosd" src="images/calendarmenu.png">     
                            </td>
                            <td align="center">
                                Plan de Accion
                            </tr>    
                        </table>   
                    </a>

                     <?php $urlacc = "index.php?r=cliente%2Findex&idemp=".Yii::$app->user->identity->idemp ?>
                    
                    <a href="<?=$urlacc?>">
                         <table >
                            <tr>
                            <td>
                              <img class="iconosd" src="images/peoplemenu.png">     
                            </td>
                            <td align="center">
                                Gestion de Clientes

                            </tr>    
                        </table>   
                    </a>
 
                    <?php $urlventas = "index.php?r=facturah%2Findex&idemp=".Yii::$app->user->identity->idemp ?>
                    
                    <a href="<?= $urlventas?>">
                        <table >
                            <tr>
                            <td>
                              <img class="iconosd" src="images/coinsmenu.png">     
                            </td>
                            <td align="center">
                                Ventas

                            </tr>    
                        </table>   
                    </a>

                    <?php $urlanalisis = ""; ?>    
                    <a href="<?= $urlanalisis ?>">
                        <table >
                            <tr>
                            <td>
                              <img class="iconosd" src="images/arrowmenu.png">     
                            </td>
                            <td align="center">
                                Analisis
                            </tr>    
                        </table>   
                    </a>


    </div>
</div>

          </ul>
        </li>



      </ul>
   </div>

    <div class="navbar-header navbar-right pull-right">
     
      <ul class="nav navbar-nav navbar-left">
        <li><a href="/news">Home</a></li>
        <li><a href="/Shop">About</a></li>
      </ul>

      <ul class="nav pull-left">
        
        <li class="navbar-text pull-left">
            <a href="index.php?r=site%2Fdatos">
                <img src="images/iconos/people.png">
            </a>
        </li>
        <?php if(Yii::$app->user->isGuest){
            echo '<li class="navbar-text pull-left">Login</li>';
        }else{         
        echo '<li class="navbar-text pull-left">'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    ' '.Html::img('@web/images/iconos/exit.png' ). Yii::$app->user->identity->username . ' ',
                    ['class' => 'btn btn-link ']
                )
                . Html::endForm()
                . '</li>';
       } ?>

      </ul>


     </div>
  </div>
</nav>
<?/**
    <?php 
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logopeq77.png', ['alt'=>Yii::$app->name]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
       ]);
         /*
        echo Nav::widget([

                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
         
                            ['label' => '  ', 

                            'items' => [
                            ['label' => 'Action', 'url' => '#'],
                            ['label' => 'Another action', 'url' => '#'],
                            ['label' => 'Something else here', 'url' => '#'],
                            ],
                            'options' => ['class' => 'navbarimglogo',
                            'style' => 'display: block!important;'],
                        ],
         
                    ],
     
        ]); */ 
        /*
             echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right navtop'],
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
         

            ['label' => '', 'url' => ['/site/datos'],'options'=> ['class'=>'imgdatos']],
            
//DFend
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : 
            (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    ''.Html::img('@web/images/iconos/exit.png' ). Yii::$app->user->identity->username . '',
                    ['class' => 'btn btn-link navtopsalir']
                )
                . Html::endForm()
                . '</li>'
            )

        ],
    ]);
    NavBar::end();
  */  ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?=  $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container" align="center" >
        <p >
            &copy;wwww.growthmipymes.com <?= date('Y') ?>
            <br />
            Desarrollado por <a href="http://www.ideartics.com" target="_blank"> IdearTics </a>
    
        </p>
    </div>

</footer>

<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
