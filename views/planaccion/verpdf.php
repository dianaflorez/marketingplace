<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use yii\bootstrap\Tabs;
use kartik\date\DatePicker;


$this->title = $emp->nombre.' - Plan Accion';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?php echo $this->title;?></h2>
<table border="1" cellspacing=0 cellpadding=2 bordercolor="#cc0000" align="center">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Estado</th>
        <th>Elemento</th>
        <th>Costo</th>
     </tr>

    <?php $total = 0;?>

    <?php foreach($model as $row): ?>
    <tr>
        <td colspan="7" >
            <div class="letraazul"><h3><?= $row->nombre ?></h3></div>
        </td>
    </tr>        
    <?php $suma = 0;?>
    <?php 
    //ORGANIZACION DEL ARRAY INTERNO PARA ACCIONES
      $acciones = array();
      foreach($row->paaccions as $acc){
        $accele = array(
                      'orden'   =>$acc->orden, 
                      'idaccion'=>$acc->idaccion,
                      'descripcion'   =>$acc->descripcion,
                      'fecini'=>$acc->fecini,
                      'fecfin'=>$acc->fecfin,
                      'responsable' => $acc->responsable,
                      'costo' => $acc->costo,
                      'estado'=> $acc->estado);
        array_push($acciones, $accele);
      }
      $tmp = Array(); 
      foreach($acciones as &$acc) 
          $tmp[] = &$acc["orden"]; 
      array_multisort($tmp, $acciones); 
    ?>

    <?php foreach($acciones as &$acc): ?>
    <tr>
        <td valign="top"><?= $acc['descripcion'] ?></td>
        <td valign="top"><?= $acc['fecini'] ?> </td>
        <td valign="top"><?= $acc['fecfin'] ?> </td>
        <td valign="top" width="17%"><?= "-".$acc['responsable'] ?></td>
        <td valign="top"><?= $acc['estado'] ?></td> 
        <td valign="top" width="24%">
            <div class="panel panel-default">
                <div class="panel-body" style="margin: -7px">
                    <?php foreach($row->paaelementos as $ele): ?>
                      <?php if($ele->idaccion == $acc['idaccion']){?>
                        <?php echo "-".$ele->descripcion; ?><br />
                      <?php }?>
                    <?php endforeach ?>
                </div>
            </div>    
        </td>
        <td align="right" valign="top">
            <?php 
              $costo = $acc['costo']; 
              setlocale(LC_MONETARY, 'en_US.UTF-8');
              echo $costof= money_format('%.2n', $costo);
            ?>    
            <?php $suma = $suma + $costo; ?> 
           
        </td>
       
    </tr>
                <?php endforeach ?>
    <tr>
            <td colspan="6" align="right">
                <b>Total <?= $row->nombre ?>:</b>
            </td>
        
            <td  align="right">
                <?php $total = $total + $suma; ?>
                <?php
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $suma = money_format('%.2n', $suma);
                ?>
                <b><?= $suma ?></b>

            </td>
        </tr>  
                     
    <?php endforeach ?>
    <tr>
      <td colspan="6" align="right"><b>TOTAL PLAN ACCION</b> </td>
      <td align="right"><b>
             <?php
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                echo $total = money_format('%.2n', $total);
                ?></b>
               </td>
    </tr>
</table>

<?php  //IMPORTANTE Sin esto no funciona el menu del logo 
    Tabs::widget(); 
?>

