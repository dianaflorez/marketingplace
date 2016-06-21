<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use yii\bootstrap\Tabs;

 $mes = date("m",strtotime( $fecini)); 
 $anio = date("Y",strtotime( $fecini)); 
 $dia = date("d",strtotime( $fecini)); 

 $mesfin = date("m",strtotime( $fecfin)); 
 $aniofin = date("Y",strtotime( $fecfin)); 
 $diafin = date("d",strtotime( $fecfin)); 

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 

$fectri = $dia." ".$meses[$mes-1]." ".$anio." a ".$diafin." ".$meses[$mesfin-1]." ".$aniofin; 

$title = $emp->nombre.' - Plan de Acción - Trimestre '.$trimestre.' ('.$fectri.') ';
$this->params['breadcrumbs'][] = $title;
?>

<h3>
<!--Si el usuario es Comercial no mostrar -->
    <?php if (Yii::$app->user->identity->role != 1){ ?>

        <a href="<?= Url::toRoute(["planaccion/index",  "id" => $emp->idemp]) ?>">
        <?= $title ?>
    <?php } ?>    
</a>
</h3>   
<br />
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
<?php if($trimestre != 1) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 1]) ?>">Trimestre uno</a>
<?php }else{ ?>
    <a class="btn btn-warning" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 1]) ?>">Trimestre uno</a>
<?php  } ?>

<?php if($trimestre != 2) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 2]) ?>">Trimestre dos</a>
<?php }else{ ?>
    <a class="btn btn-warning" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 2]) ?>">Trimestre dos</a>
<?php } ?>

<?php if($trimestre != 3) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 3]) ?>">Trimestre tres</a>
<?php }else{ ?>
    <a class="btn btn-warning" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 3]) ?>">Trimestre tres</a>
<?php } ?>

<?php if($trimestre != 4) { ?>
    <a class="btn btn-primary" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 4]) ?>">Trimestre cuatro</a>
<?php }else{ ?>
    <a class="btn btn-warning" href="<?= Url::toRoute(["planaccion/viewplan", "id" => $idemp, "tr" => 4]) ?>">Trimestre cuatro</a>
<?php } ?>

<br />
<br />
<table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Elemento</th>
        <th>Costo</th>
        <th>Estado</th>
    </tr>
    <?php $total = 0; ?>
    <?php foreach($plana as $pa): ?>
    <tr>
        <td colspan="7">
                <b><?= $pa->nombre ?></b>
        </td>
    </tr>        
   <?php $suma = 0; ?>    
           
        <?php foreach($model as $acc): ?>
            <?php if($acc['estado'] != "Anulado"){ ?>
            <?php if($acc['idpa'] == $pa->idpa){?>
                <tr>
                    <td><?= $acc['descripcion'] ?></td>
                    <td><?= $acc['fecini'] ?></td>
                    <td><?= $acc['fecfin'] ?></td>
                    <td><?= $acc['responsable'] ?></td>
                    <td>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php foreach($elementos as $ele): ?>
                                    
                                    <?php  if($ele->idaccion == $acc['idaccion']) {
                                        echo $ele->descripcion."<br />"; 
                                    }
                                    ?>
                                
                                <?php endforeach ?>
                            </div>
                        </div>            
                    </td>
                    <td align="right">
                        <?php $costo = $acc['costo'] ?>
                        <?php
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo  money_format('%.2n', $costo);
                        ?>    
                        <?php $suma = $suma + $costo; ?>
                    </td>
                    <td><?= $acc['estado'] ?></td>
                 </tr>
            <?php }?>  
          <?php } ?>  
        <?php endforeach ?>
        <tr>
            <td colspan="5" align="right">
                <b>Total <?= $pa->nombre ?>:</b>
            </td>
        
            <td  align="right">
                <?php $total = $total + $suma; ?>
                <?php
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $suma = money_format('%.2n', $suma);
                ?>
                <b><?= $suma ?></b>
            </td>
            <td></td>
        </tr>  
    <?php endforeach ?>
    <tr>
        <td colspan="5" align="right"><b>TOTAL PLAN ACCION</b></td>
        <td align="right"><b> 
            <?php
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                echo  $total = money_format('%.2n', $total);
            ?>
            </b>   
    </tr>
</table>
<?php  //IMPORTANTE Sin esto no funciona el menu del logo 
    Tabs::widget(); 
?>
