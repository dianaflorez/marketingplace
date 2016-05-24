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

    $role = "comercial";   

    if(!Yii::$app->user->isGuest){
        $role = Yii::$app->user->identity->role; 
        if($role == 7){
            $role = "supermegaadmin";
        }elseif($role == 4){
            $role = "superadmin";
        }elseif($role == 2){
            $role = "adminemp";
        }else{
            $role = "comercial";
        }
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
    $urlinicio = "index.php?r=empresainf%2Findex&id=".Yii::$app->user->identity->idemp;
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
                            $urlpa = "index.php?r=planaccion%2Fviewplan&id=".Yii::$app->user->identity->idemp."&tr=1";
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
                    <?php
                        if($role == "adminemp" || $role == "superadmin"){ ?>
                      
                    <?php $urlanalisis = "index.php?r=analisis%2Findex&idemp=".Yii::$app->user->identity->idemp; ?>    
                    <a href="<?= $urlanalisis ?>">
                        <table >
                            <tr>
                            <td>
                              <img class="iconosd" src="images/arrowmenu.png">     
                            </td>
                            <td align="center">
                                Evaluacion
                            </tr>    
                        </table>   
                    </a>

                    <?php } ?>
    </div>
</div>
<!--FIN MENU -->
          </ul>
        </li>
      </ul>
   </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <div class="navarmia navbar-header navbar-right pull-right 
                collapse navbar-collapse navbar-ex1-collapse">
     
      <ul class="nav navbar-nav navbar-left">
        <?php if($role == "supermegaadmin"){ ?>
            <li><a href="index.php?r=site%2Fsuperadmin">SAdm</a></li>
            <li><a href="index.php?r=site%2Fadminemp">AEmp</a></li>
            <li><a href="index.php?r=site%2Fcomercial">Com</a></li>
            <li><a href="index.php?r=site%2Fempresas">Todas</a></li>
            <li><a href="index.php?r=usuario%2Findex">Usu</a></li>
            <li><a href="index.php?r=tipo%2Findex">Tipo</a></li>
        
        <?php }elseif($role == "superadmin"){ ?>
            <li>
                <a href="index.php?r=site%2Fsuperadmin" title="Inicio">
                    <table><tr>
                        <td>
                            <img src="images/iconos/home.png" >
                        </td>
                        <td><div class="menutitle">Inicio</div></td>
                    </tr></table>
                </a>
            </li>
            <li>
                <a href="index.php?r=usuario%2Findex">
                    <table>
                        <tr>
                            <td><img src="images/iconos/usuarios.png" ></td>
                            <td><div class="menutitle">Usuarios</div></td>
                        </tr>
                    </table>
                </a>
            </li>
            
        <?php }elseif($role == "adminemp"){ ?>
            <li>
                <a href="index.php?r=site%2Fadminemp" title="Inicio">
                    <table>
                        <tr>
                            <td><img src="images/iconos/home.png" ></td>
                            <td><div class="menutitle">Inicio</div></td>
                        </tr>
                    </table>
                </a>
            </li>
      
        <?php }elseif($role == "comercial"){ ?>
            <li><a href="index.php?r=site%2Fcomercial" title="Inicio">
                    <table>
                        <tr>
                            <td><img src="images/iconos/home.png" ></td>
                            <td><div class="menutitle">Inicio</div></td>
                        </tr>
                    </table>
                </a></li>
             
        <?php }else{ ?>
            <li><a href="index.php?r=site%2Findex" title="Inicio">
                    <table>
                        <tr>
                            <td><img src="images/iconos/home.png" ></td>
                            <td><div class="menutitle">Inicio</div></td>
                        </tr>
                    </table>
                </a></li>
        <?php } ?>    

        <li><a href="index.php?r=site%2Fabout" title="Acerca de">
                <table>
                        <tr>
                            <td><img src="images/iconos/about.png" ></td>
                            <td><div class="menutitle">Acerca de</div></td>
                        </tr>
                    </table>
            </a></li>
        <?php if($role == "supermegaadmin" || $role == "superadmin"){ ?>
            <li><a href="index.php?r=empresa%2Findex" title="Empresas">
                <table>
                        <tr>
                            <td><img src="images/iconos/empresas.png" ></td>
                            <td><div class="menutitle">Empresas</div></td>
                        </tr>
                    </table>
            </a></li>
        <?php } ?>
     
        <li class="navbar-ppal pull-left">
            <a href="index.php?r=site%2Fdatos" title="Mis Datos">
                <table>
                        <tr>
                            <td><img src="images/iconos/datos.png" ></td>
                            <td><div class="menutitle">Datos</div></td>
                        </tr>
                    </table>
            </a>
        </li>
        <?php if(Yii::$app->user->isGuest){
            echo '<li class="navbar-ppal pull-left">Login</li>';
        }else{         
        echo '<li class="navbar-ppal pull-left">'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    ' '.Html::img('@web/images/iconos/exit.png' ). Yii::$app->user->identity->username . ' ',
                    ['class' => 'btn btn-link navbarusu']
                )
                . Html::endForm()
                . '</li>';
       } ?>

      </ul>
    </div>

  </div>

</nav>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?=  $content ?>
    </div>
</div>

<footer id="footer" class="footer">
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
