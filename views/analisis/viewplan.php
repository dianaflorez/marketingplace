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
<a href="<?= Url::toRoute(["analisis/index",  "idemp" => $emp->idemp]) ?>">
    <?= $title ?>
</a>
</h3>   
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

 <?= Html::beginForm( Url::toRoute("analisis/viewplan"), "POST") ?>

<div class="row">
    <div class="col-xs-10 col-md-4">
        <?php
            echo '<label class="control-label">Fechas</label>';

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
        <input type="hidden" name="idemp" value="<?= $emp->idemp ?>">
        <button name="btn" value="1" type="submit" class="btn btn-primary">Generar</button>
        <button name="btn" value="2" type="submit" class="btn btn-danger"
                onclick="document.this.form.target='_blank'"
                >Ver Pdf</button>
    </div>
</div>
<?= Html::endForm() ?>

<h3>Plan de Accion <?php echo ' - '.$emp->nombre;?></h3>
<div class="rwd">
<table class="table table-striped  table-bordered table-showPageSummary">
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
                    <td><?= $acc['descripcion'] ?></td>
                    <td><?= $acc['fecini'] ?></td>
                    <td><?= $acc['fecfin'] ?></td>
                    <td><?= $acc['responsable'] ?></td>
                    <td><?= $acc['estado'] ?></td>
                    <td>
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
                    <td align="right">
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
</div>