<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;

$this->title = $emp->nombre.' - Agenda';
$this->params['breadcrumbs'][] = $this->title;
?>
<h2>
<a href="<?= Url::toRoute(["cliente/index",  "idemp" => $emp->idemp]) ?>">
    <?php echo $emp->nombre." - Nueva cita"; ?>
</a>
</h2>   

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
<div class="cita-index">

    <p>
        <?= Html::a('Nueva Cita', ['create',"idemp" => $emp->idemp], ['class' => 'btn btn-success']) ?>
    </p>
  <table class="table table-striped  table-bordered table-showPageSummary">
    <tr>
        <th>Nombre</th>
        <th>Inicia</th>
        <th>Fin</th>
        <th>Responsable</th>
        <th>Elemento</th>
        <th>Costo</th>
        <th>Estado</th>
        <th class="action-column ">&nbsp;</th>
    </tr>

    <?php foreach($model as $row): ?>
    <tr>
        <td colspan="7">
            <b><?= $row->idcli ?></b>
        <td>
    </tr>        
    <?php endforeach?>
    </table>    
</div>
