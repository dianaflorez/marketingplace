<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

//IMPORTANTE Sin esto no funciona el menu del logo 
use yii\bootstrap\Tabs;
Tabs::widget(); 
//FIN

$this->title = $modelemp->nombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresainf-index">
  <div class="row">
    <div class="col-xs-7">
      <h2><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="col-xs-offset-1 col-md-4" align="right">  

    <?php if($urllogo){ 
        ?>
          <?= Html::img($urllogo,["height"=>"70px"]); ?>
      <?php }else{ ?>
           <a href="<?= Url::toRoute(["empresainf/logo", "idemp" => $idemp, "doc" => 0]) ?>">Subir Logo</a>
    
      <?php  } ?>  
    </div>

  </div>  
    <?php   echo "NIT. ".$modelemp->nit; ?>
    <br /><br />
   
    <?php $ctlineas = 1; ?> 
   <?php foreach($model as $row): ?>

    <?php if($ctlineas <= 4){  $ctlineas ++; ?>
    <div class="panel panel-default">
      <div class="panel-heading"><?= $row->idtipo0->nombre ?></div>
      <div class="panel-body">
        <?= $row->inf ?>
        <br /><br />
        <?php if (Yii::$app->user->identity->role != 1){ ?>
            <!-- Update -->
            <a href="<?= Url::toRoute(["empresainf/update", "id" => $row->idinf]) ?>" title="Actualizar" aria-label="Actualizar">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <!--End Update-->
        
            <!--Delete-->
             <a href="#" data-toggle="modal" data-target="#idinf_<?= $row->idinf ?>" title="Eliminar" aria-label="Eliminar">
             <span class="glyphicon glyphicon-trash"></span>
             </a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="idinf_<?= $row->idinf ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar Empresa</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar <?= $row->idtipo0->nombre ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("empresainf/delete"), "POST") ?>
                                    <input type="hidden" name="idinf" value="<?= $row->idinf ?>">
                                    <input type="hidden" name="idemp" value="<?= $row->idemp ?>">

                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->            
            </a>
            <!--End Delete--> 

         <?php } ?>   
      </div>
    </div>
    <?php } ?>
    <?php endforeach ?>

    <!--Si el usuario es Comercial no mostrar -->
    <?php if (Yii::$app->user->identity->role != 1){ ?>
          <div class="panel panel-default wellazul">
            <div class="panel-body">
                <b class="whitefont">Documentos</b><br />
                <?php $ctlineas = 0; ?>
                <?php foreach($model as $row): 
                  $ctlineas ++; 
              
                if($ctlineas > 4 && $row->inf != "logo" && $row->inf != "link"){  
                  $ctlineas ++; 
                  ?>
                    <div class="cajita">
                     <p class="cuadroblanco"><?=$row->inf?></p>
                  <?php
                  if($row->descripcion){
                    echo Html::img('@web/images/iconos/lito.png',["height"=>"20px", "class"=>"estado"]);
                  }else{ ?>
                    <a class="estado" href="<?= Url::toRoute(["empresainf/logo", 
                                     "idemp"  => $idemp, 
                                     "doc"    => $row->idinf,
                                     ]) ?>">
                      <?=Html::img('@web/images/iconos/add.png',["height"=>"27px"])?>
                    </a>
            <?php } ?>
                     <br />
                    </div>
               <?php } ?>

        <?php endforeach ?>
         <br />
         <br />
         <br />

         <a href="<?= Url::toRoute(["empresainf/logo", 
                                     "idemp"  => $idemp, 
                                     "doc"    => 0,
                                     "new"    => 15, 
                                     ]) ?>">
            <?=Html::img('@web/images/iconos/add.png',["height"=>"27px"])?>Nuevo Documento
          </a>
     
      <br />

         <a href="<?= Url::toRoute(["empresainf/create", 
                                     "idemp"  => $idemp
                                     ]) ?>">
            <?=Html::img('@web/images/iconos/add.png',["height"=>"27px"])?>Nuevo Link
          </a>
     
         
            </div>
          </div>
    <?php } ?>      
</div>
