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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $model  = Facturah::find()
                ->joinWith(['idcli0'])
                ->where(['facturah.idemp' => $idemp ])
//                ->joinWith(['elementos'])
           //     ->where(['elemento.idemp' => $id])
                ->all();
            
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('index', [
            'model'   => $model,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
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
       
        $model = new Facturah();
        $model->idusu   = Yii::$app->user->identity->idusu;
        $model->idemp   = $idemp;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);

        $model->refpago = substr($emp->nombre,0,2).time();
        $model->fecmod  = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        //Credito
        $modelcredito = new Faccredito();
       
        //Factura detalle
        $modelfd = new Facturad();
    
        //Verifica la identidad del usuario quien registra Q solo pertenezca a esta empresa
        if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7){
            $model->idemp        = Yii::$app->user->identity->idemp;
            $modeldf->idemp      = Yii::$app->user->identity->idemp;
            $modelcredito->idemp = Yii::$app->user->identity->idemp;
        }

        $clientes   = ArrayHelper::map(Cliente::find()
                        ->where(['idemp' => $model->idemp])->all(), 'idcli', 'nombre1');
     
        $productos  = ArrayHelper::map(Producto::find()->where(['idemp' => $model->idemp])->all(), 'idpro', 'nombre');
        
        $model->totalnormal = 0;
        $model->totaldes    = 0;
        $model->vlrdes      = 0;
        $model->neto        = 0;
        $model->vlriva      = 0;
        $model->total       = $model->total;
        $tipo = ['Pagada'=>'Pagada', 'Credito'=>'Crédito'];  
        
        if ($model->load(Yii::$app->request->post()) && 
            $modelfd->load(Yii::$app->request->post()) &&
            $modelcredito->load(Yii::$app->request->post()) ) {
            
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
                try{

                   if($modelfd->save()){

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

                   }
                        print_r($modelfd->getErrors());
                        print_r($modelcredito->getErrors());

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
        $modelcredito = new Faccredito();
     
        //Detalles factura         
        $modelfd    = new Facturad;

        //Para productos ya guardados
        $facturad   = Facturad::find()
                        ->joinWith(['idpro0'])
                        ->where(['idfh' => $model->idfh])
                        ->all();

        $clientes   = ArrayHelper::map(Cliente::find()
                        ->where(['idemp' => $model->idemp])->all(), 'idcli', 'nombre1');
        $emp        = Empresa::findOne(['idemp' => $model->idemp]);
        $productos  = ArrayHelper::map(Producto::find()->where(['idemp' => $model->idemp])->all(), 'idpro', 'nombre');
        $tipo = ['Pagada'=>'Pagada', 'Credito'=>'Crédito'];  
        

        if ($model->load(Yii::$app->request->post()) && $modelfd->load(Yii::$app->request->post())) {
            
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
               
                    return $this->redirect(['update', 'id' => $model->idfh]);
            }
       } else {
            return $this->render('update', [
                'model'     => $model,
                'modelfd'   => $modelfd,
                'modelcredito' => $modelcredito,
                'clientes'  => $clientes,
                'emp'       => $emp,
                'productos' => $productos,
                'tipo'      => $tipo,
                'facturad'  => $facturad,  
            ]);
        }
    }

    /**
     * Deletes an existing Facturah model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
