<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use kartik\date\DatePicker;

$title = 'Ventas Plan Accion '.$emp->nombre.' - Fecha ('.$fectri.') ';
$this->params['breadcrumbs'][] = $title;
?>
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

<h2><?=$emp->nombre." ";?>Plan de Accion</h2>
<div class="row">
    <div class="col-xs-10 col-md-4">
        <?= Html::beginForm(Url::toRoute("analisis/viewplan"), "POST") ?>
        <?php
            echo DatePicker::widget([
                'name' => 'fecini',
                'value' => $fecini,
                'type' => DatePicker::TYPE_RANGE,
                'name2' => 'fecfin',
                'value2' => $fecfin,
                'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-m-dd'
                ]
            ]);
            ?>
    </div>        
    <div class="col-xs-10 col-md-4">
        <br />
    </div>
</div>

<table border="1" cellspacing=0 cellpadding=2 bordercolor="#cc0000" align="center">

    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Elemento</th>
        <th>Estado</th>
        <th>Costo</th>
    </tr>
    <?php $sumatotal = 0; ?>
    <?php foreach($plana as $pa): ?>
    <tr>
        <td colspan="7">
                <b><?= $pa->nombre ?></b>
        </td>
    </tr>        
        <?php $suma = 0;?>
        <?php foreach($model as $acc): ?>

            <?php if($acc['idpa'] == $pa->idpa){?>
                <tr>
                    <td valign="top"><?= $acc['descripcion'] ?></td>
                    <td valign="top"><?= $acc['fecini'] ?></td>
                    <td valign="top"><?= $acc['fecfin'] ?></td>
                    <td valign="top"><?= $acc['responsable'] ?></td>
                    <td valign="top" width="20%"><?= "*".$acc['estado'] ?></td>
                    <td valign="top">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php foreach($elementos as $ele): ?>
                                    
                                    <?php if($ele->idaccion == $acc['idaccion']) {
                                        echo $ele->descripcion."<br />"; 
                                    }
                                    ?>
                                
                                <?php endforeach ?>
                            </div>
                        </div>            
                    </td>
                    <td valign="top" align="right">
                        <?php $costo = $acc['costo'] ?>
                        <?php
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo  money_format('%.2n', $costo);
                        ?>    
                        <?php $suma = $suma + $costo; ?>
                    </td>
                 </tr>
            <?php }?>     
        <?php endforeach ?>
        <tr>
            <td colspan="5" align="right">
                <b>Total <?= $pa->nombre ?>:</b>
            </td>
        
            <td  align="right">
                <?php
                $sumatotal = $sumatotal + $suma;
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $suma = money_format('%.2n', $suma);

                ?>
                <b><?= $suma ?></b>
            </td>
            <td></td>
        </tr>     
    <?php endforeach ?>
     <tr>
            <td colspan="5" align="right">
                <b>TOTAL:</b>
            </td>
        
            <td  align="right">
                <?php
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $sumatotal = money_format('%.2n', $sumatotal);
                ?>
                <b><?= $sumatotal ?></b>
            </td>
            <td></td>
        </tr>
</table>
