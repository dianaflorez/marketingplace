<?php

namespace app\controllers;

use Yii;
use app\models\Facturah;
use app\models\Facturad;
use app\models\Faccredito;
use app\models\Cliente;
use app\models\Producto;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\base\ErrorException;
use yii\helpers\Url;
use yii\helpers\Html;  //encode
use yii\filters\AccessControl;
use app\models\User;


/**
 * FacturahController implements the CRUD actions for Facturah model.
 */
class FacturahController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['index', 'create', 'update','view'],
            'rules' => [
                [
                    //El administrador tiene permisos sobre las siguientes acciones
                    'actions' => ['index',  'create', 'update','view'],
                    //Esta propiedad establece que tiene permisos
                    'allow' => true,
                    //Usuarios autenticados, el signo ? es para invitados
                    'roles' => ['@'],
                    //Este método nos permite crear un filtro sobre la identidad del usuario
                    //y así establecer si tiene permisos o no
                    'matchCallback' => function ($rule, $action) {
                        //Llamada al método que comprueba si es un administrador
                        return User::isSuperMegaAdmin(Yii::$app->user->identity->id);
                    },
                ],
                [
                   //Los usuarios simples tienen permisos sobre las siguientes acciones
                   'actions' => ['index', 'create', 'update','view'],
                   //Esta propiedad establece que tiene permisos
                   'allow' => true,
                   //Usuarios autenticados, el signo ? es para invitados
                   'roles' => ['@'],
                   //Este método nos permite crear un filtro sobre la identidad del usuario
                   //y así establecer si tiene permisos o no
                   'matchCallback' => function ($rule, $action) {
                      //Llamada al método que comprueba si es un usuario simple
                      return User::isSuperAdmin(Yii::$app->user->identity->id);
                  },
               ],
                [
                   //Los usuarios simples tienen permisos sobre las siguientes acciones
                   'actions' => ['index', 'create', 'update','view'],
                   //Esta propiedad establece que tiene permisos
                   'allow' => true,
                   //Usuarios autenticados, el signo ? es para invitados
                   'roles' => ['@'],
                   //Este método nos permite crear un filtro sobre la identidad del usuario
                   //y así establecer si tiene permisos o no
                   'matchCallback' => function ($rule, $action) {
                      //Llamada al método que comprueba si es un usuario simple
                      return User::isAdminEmp(Yii::$app->user->identity->id);
                  },
               ],
                [
                   //Los usuarios simples tienen permisos sobre las siguientes acciones
                   'actions' => ['index', 'create', 'update','view'],
                   //Esta propiedad establece que tiene permisos
                   'allow' => true,
                   //Usuarios autenticados, el signo ? es para invitados
                   'roles' => ['@'],
                   //Este método nos permite crear un filtro sobre la identidad del usuario
                   //y así establecer si tiene permisos o no
                   'matchCallback' => function ($rule, $action) {
                      //Llamada al método que comprueba si es un usuario simple
                      return User::isComercial(Yii::$app->user->identity->id);
                  },
               ],
            ],
        ],
         //Controla el modo en que se accede a las acciones, en este ejemplo a la acción logout
         //sólo se puede acceder a través del método post
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ],
      ];
    }

    /**
     * Lists all Facturah models.
     * @return mixed
     */
    public function actionIndex($idemp, $msg=null)
    {
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;

        if(Yii::$app->request->post())
        {
          $idcli = Html::encode($_POST["cliente_id"]);
          if($idcli){
             $model  = Facturah::find()
                ->joinWith(['idcli0'])
                ->where(['facturah.idemp' => $idemp , 'cliente.idcli' => $idcli])
                ->orderBy('facturah.fecha desc')
                ->all();
          }else{
              $model  = Facturah::find()
                ->joinWith(['idcli0'])
                ->where(['facturah.idemp' => $idemp ])
                ->orderBy('facturah.fecha desc')
                ->all();
          }
        }else{
       
          $model  = Facturah::find()
                ->joinWith(['idcli0'])
                ->where(['facturah.idemp' => $idemp ])
                ->orderBy('facturah.fecha desc')
                ->all();
        }
                
        $creditos = Faccredito::find()
                  ->where(['idemp'=>$idemp])->all();        
            
        $emp    = Empresa::findOne(['idemp' => $idemp]);
  
        $data = Cliente::find()
                ->where(['idemp' => $idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();

        return $this->render('index', [
            'model'   => $model,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
            'creditos'=> $creditos,
            'data'    => $data,
        ]);
    }

    /**
     * Displays a single Facturah model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Facturah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionListprice($id) {
        $data = Producto::findOne(['idpro' => $id]);
        return $data->vlrsiniva;
    }
    public function actionCalprice($qty,$vlr) {
        $data = $qty*$vlr;
        return $data;
    }
    public function actionCreate($idemp)
    {
       if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
       
        $model = new Facturah();
        $model->idusu   = Yii::$app->user->identity->idusu;
        $model->idemp   = $idemp;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);

        $refpago = facturah::find()->where(['idemp'=>$idemp])->count();

        $model->refpago = $refpago;//substr($emp->nombre,0,2).time();
        $model->fecmod  = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        //Credito
        $modelcredito = new Faccredito();
       
        //Factura detalle
        $modelfd = new Facturad();
    
        /*Verifica la identidad del usuario quien registra Q solo pertenezca a esta empresa
         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7){
            $model->idemp        = Yii::$app->user->identity->idemp;
            $modeldf->idemp      = $idemp;//Yii::$app->user->identity->idemp;
            $modelcredito->idemp = $idemp; //Yii::$app->user->identity->idemp;
        }
*/
        $clientes   = ArrayHelper::map(Cliente::find()
                        ->where(['idemp' => $model->idemp])->all(), 'idcli', 'nombre1');
     
        $data = Cliente::find()
                ->where(['idemp' => $idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();

        $productos  = ArrayHelper::map(Producto::find()->where(['idemp' => $model->idemp])->all(), 'idpro', 'nombre');
        
        $model->totalnormal = 0;
        $model->totaldes    = 0;
        $model->vlrdes      = 0;
        $model->neto        = 0;
        $model->vlriva      = 0;
        $model->total       = $model->total;
        $tipo = ['Pagada'=>'Pagada', 'Credito'=>'Crédito'];  
        
        if ($model->load(Yii::$app->request->post()) && 
            $modelfd->load(Yii::$app->request->post()) 

            &&  $modelcredito->load(Yii::$app->request->post()) 
            ) {
            
            if($model->save()){
                $modelfd->idfh   = $model->idfh;
                $modelfd->idemp  = $model->idemp;
                $modelfd->idpro  = $modelfd->idpro;

                $modelfd->vlr1   = $modelfd->vlr1;  //Vlr del producto 
                $modelfd->qty    = $modelfd->qty;
                $modelfd->vlr2   = str_replace(".","",$modelfd->valor);//vlr en el que se lo vendio realmente

                $modelfd->valor  = str_replace(".","",$modelfd->valor);

                $modelfd->descuento  = (Int)$modelfd->vlr1-(Int)$modelfd->vlr2;  

                $modelfd->neto   = $modelfd->neto  ;               
                $modelfd->total  = $modelfd->total;               
                $modelfd->usumod = Yii::$app->user->identity->idusu;
                try{

                   if($modelfd->save()){

                     /*   if($model->tipo == "Credito"){
                            $modelcredito->idfh     = $model->idfh;
                            $modelcredito->idemp    = $model->idemp;
                            $modelcredito->totalfh  = $model->total;
                            $modelcredito->abono    = $modelcredito->abono;
                            $modelcredito->saldo    = (int)$model->total - $modelcredito->abono;
                            $modelcredito->usumod = Yii::$app->user->identity->idusu;
                            
                            if($modelcredito->save()){
                                return $this->redirect(['update', 'id' => $model->idfh]);
                            }

                        }else{
                            return $this->redirect(['update', 'id' => $model->idfh]);
                        }

                        */    
                        return $this->redirect(['update', 'id' => $model->idfh]);


                   }
                        print_r($modelfd->getErrors());
                      //  print_r($modelcredito->getErrors());

                } catch (ErrorException $e) {
                    Yii::warning("Division by zero.".$e);
                    echo $e;
                    echo "<meta http-equiv='refresh' content='16; ".Url::toRoute(["update",
                                                "id"=>$model->idemp])."'>";
                     //   return $this->redirect(['update', 'id' => $model->idfh]);

                }
            }
        } else {
            return $this->render('create', [
                'model'     => $model,
                'modelfd'   => $modelfd,
                'modelcredito'   => $modelcredito,
                'clientes'  => $clientes,
                'emp'       => $emp,
                'productos' => $productos,
                'tipo'      => $tipo,
                'facturad'  => array(),
                'data'      => $data,
            ]);
        }
    }

    /**
     * Updates an existing Facturah model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->total       = $model->total;
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;
     
        //Credito
        if($model->tipo == "Credito")
            $modelcredito = Faccredito::findOne(['idfh' => $model->idfh]);
        else 
            $modelcredito = new Faccredito();

        //Detalles factura         
        $modelfd    = new Facturad;

        //Para productos ya guardados
        $facturad   = Facturad::find()
                        ->joinWith(['idpro0'])
                        ->where(['idfh' => $model->idfh])
                        ->all();

        //Clientes                  
        $data = Cliente::find()
                ->where(['idemp' => $model->idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();

        $cliente   = Cliente::findOne(['idcli' =>$model->idcli]);

        $emp        = Empresa::findOne(['idemp' => $model->idemp]);
        $productos  = ArrayHelper::map(Producto::find()->where(['idemp' => $model->idemp])->all(), 'idpro', 'nombre');
        $tipo = ['Pagada'=>'Pagada', 'Credito'=>'Crédito'];  
        

        if ($model->load(Yii::$app->request->post()) && 
            $modelfd->load(Yii::$app->request->post()) &&
            $modelcredito->load(Yii::$app->request->post())) {
            
            $model->tipo ="En Proceso";
            
            if($model->save()){
                $modelfd->idfh   = $model->idfh;
                $modelfd->idemp  = $model->idemp;
                $modelfd->idpro  = $modelfd->idpro;

                $modelfd->vlr1   = $modelfd->vlr1;  //Vlr del producto 
                $modelfd->qty    = $modelfd->qty;
                $modelfd->vlr2   = $modelfd->valor;   //vlr en el que se lo vendio realmente

                $modelfd->valor  = $modelfd->valor;

                $modelfd->descuento  = (Int)$modelfd->vlr1-(Int)$modelfd->vlr2;  

                $modelfd->neto   = $modelfd->neto  ;               
                $modelfd->total  = $modelfd->total;               
                $modelfd->usumod = Yii::$app->user->identity->idusu;
                
                if ( $modelfd->save(false)) 
            
                    if($model->tipo == "Credito"){
                        $modelcredito->idfh     = $model->idfh;
                        $modelcredito->idemp    = $model->idemp;
                        $modelcredito->totalfh  = $model->total;
                        $modelcredito->abono    = $modelcredito->abono;
                        $modelcredito->saldo    = (int)$model->total - $modelcredito->abono;
                        $modelcredito->usumod = Yii::$app->user->identity->idusu;
                        
                        if($modelcredito->save()){
                            return $this->redirect(['update', 'id' => $model->idfh]);
                        }

                    }else{
                        return $this->redirect(['update', 'id' => $model->idfh]);
                    }
            }else {

                                print_r($model->getErrors());

            }
       } else {
            return $this->render('update', [
                'model'     => $model,
                'modelfd'   => $modelfd,
                'modelcredito' => $modelcredito,
                'emp'       => $emp,
                'productos' => $productos,
                'tipo'      => $tipo,
                'facturad'  => $facturad,  
                'data'      => $data,
                'cliente'   => $cliente,
            ]);
        }
    }

   public function actionUpdateend()
    {

        //$msg  = "Exito!!!";  
        if(Yii::$app->request->post())
        {
            $cita   = null;
            $idfh   = Html::encode($_POST["idfh"]);
            $tipo   = Html::encode($_POST["tipo"]);
            $abono  = Html::encode($_POST["abono"]);
            $idemp  = Html::encode($_POST["idemp"]);

            if(isset($_POST["cita"])){
              $cita = Html::encode($_POST["idemp"]);
            }

            if($idfh && $tipo){
            
                //Facturah
                $modelfh = Facturah::findOne(['idfh' => $idfh]);
                $modelfh->tipo     = trim($tipo);
                $modelfh->fecmod = date('Y.m.d h:i:s');
                $modelfh->usumod = Yii::$app->user->identity->idusu;
             
                if($modelfh->save()){ 
            
                    if($tipo == "Credito"){
                        //Credito
                        $modelcredito = new Faccredito;
                        $modelcredito->idfh     = $modelfh->idfh;
                        $modelcredito->idemp    = $modelfh->idemp;
                        $modelcredito->totalfh  = $modelfh->total;
                        $modelcredito->abono    = $abono;
                        $modelcredito->saldo    = (int)$modelfh->total - $abono;
                        $modelcredito->fecmod   = date('Y.m.d h:i:s');
                        $modelcredito->usumod   = Yii::$app->user->identity->idusu;
                 
                        if($modelcredito->save()){

                          if($cita == 1){
                            return $this->redirect(['cita/index', 'idemp' => $modelfh->idemp]);
                          }else{
                            return $this->redirect(['facturah/index', 'idemp' => $modelfh->idemp]);
                          }

                        }else{
                            print_r($modelcredito->getErrors());
                        }
                    }

                    if($cita == 1){
                      return $this->redirect(['cita/create', 'idemp' => $modelfh->idemp]);
                    }else{  
                      return $this->redirect(['index', 'idemp' => $modelfh->idemp]);
                    }

                } else{
                    print_r($model->getErrors());
                }
                
            }else{  //No hay datos
                return $this->redirect(['index', 'idemp' => $idemp]);

            }
        }else echo $msg ="aqui estoy";
    }

    /**
     * Deletes an existing Facturah model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
      if(Yii::$app->request->post()){
        $idfh   = Html::encode($_POST["idfh"]);
        $idemp  = Html::encode($_POST["idemp"]);

        if($idfh){
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
          //Facturah
          $modelfh = Facturah::findOne(['idfh' => $idfh]);
          $modelfh->estado = "Anulada";
          $modelfh->fecmod = date('Y.m.d h:i:s');
          $modelfh->usumod = Yii::$app->user->identity->idusu;
       
          if($modelfh->save(false)){ 
                 //   var_dump($modelfh->getErrors());

            return $this->redirect(['index', 'idemp' => $idemp]);

          }else{
            var_dump($modelfh->getErrors());
          }
        }
      }  
    }

    /**
     * Finds the Facturah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Facturah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Facturah::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
