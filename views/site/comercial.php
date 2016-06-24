<?php 
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

$this->title = $modelemp->nombre;
?>
<div class="empresainf-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php   echo "NIT. ".$modelemp->nit; ?>
    <br /><br />
   
     <br /><br />
<div class="fondo">   
  <div class="row" >


<div class="well col-xs-offset-1 col-xs-10 col-xs-offset-1 
                  col-sm-offset-1 col-sm-10 col-md-offset-1" align="center">
          <div class="row" align="center">
            
            <div class="col-xs-5 col-sm-offset-3 col-sm-3 btninicio" align="center">
                <a href="index.php?r=empresainf%2Findex&id=<?=$idemp?>">
                   <img class="iconos" src="images/suitcase.png">  
                    <br />   
                    Información Empresa
                </a>    
                
            </div>
            <div class="col-xs-offset-3 col-xs-5 col-sm-3 btninicio" align="center">
               <a href="index.php?r=pmcontenido%2Findex&id=<?=$idemp?>&activo=pm1">

                   <img class="iconos" src="images/location.png" > <br />    
                    Plan de Mercadeo
                    <br />
                </a>        
            </div>
            <div class="col-xs-5  col-sm-3 btninicio" align="center">

                <a href="index.php?r=planaccion%2Fviewplan&id=<?=$idemp?>&tr=1">
                    <img class="iconos" src="images/calendar.png"> <br />    

                    Plan de Acción
                </a>    
            </div>
       
            <div class=" col-xs-5 col-sm-3 btninicio" align="center">
                <a href="index.php?r=cliente%2Findex&idemp=<?=$idemp?>">
                    <img class="iconos" src="images/people.png"> <br />    
                    Gestión de Clientes
                </a>
            </div>
            <div class="col-xs-5 col-sm-3 btninicio" align="center">
                  <a href="index.php?r=facturah%2Findex&idemp=<?=$idemp?>">
                    <img class="iconos" src="images/coins.png"> <br />    
                    Ventas
                </a>    
            </div>
           <div class="col-xs-10 col-sm-10 btninicio" align="center">
                    <img class="iconomodelo" src="images/modelomercadeo.jpg"> <br />    
                
            </div>

       
      </div>
    </div>





  </div>
</div>