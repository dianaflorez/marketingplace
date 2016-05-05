<?php

namespace app\controllers;

use Yii;
use app\models\Planaccion;
use app\models\Paaelemento;
use app\models\Empresa;
use app\models\Facturah;
use app\models\Facturad;
use app\models\elemento;
use app\models\Accion;
use app\models\Usuario;
use app\models\Cliente;
use app\models\Dirtel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use yii\db\Query;
use mPDF;
use yii\helpers\Html;

/**
 * PlanaccionController implements the CRUD actions for Planaccion model.
 */
class AnalisisController extends Controller
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
     * Lists all Planaccion models.
     * @return mixed
     */
    public function actionIndex($idemp,$msg=null)
    {      
        //Si un usuario q no es adm Solo puede ver su propia plan accion 
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        //*****************************
        //Esto es para el tab de Mercadeo
        $connection = \Yii::$app->db;
        $sql = "SELECT date_part('month', MIN(fecini)) as mes FROM paaccion WHERE idemp = ".$idemp;
        $model = $connection->createCommand($sql);
        $mesinicial = $model->queryScalar();

        $sqlyear = "SELECT date_part('year', MIN(fecini)) as anio FROM paaccion WHERE idemp = ".$idemp;
        $modelyear = $connection->createCommand($sqlyear);
        $year = $modelyear->queryScalar();

        $fecini = $year."-".$mesinicial."-01";

        $fecfin = date('Y-m-d', strtotime("{$fecini} + 3 month"));
        $fecfin = date('Y-m-d', strtotime("{$fecfin} - 1 day"));
        
        $tipo = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado']; 

    
        return $this->render('index', [
            'msg'      => $msg,
            'emp'      => $emp, 
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
            'tipo'      => $tipo,
       
        ]);
    }

       // get your HTML raw content without any layouts or scripts
       /* FUNCIONA

           $this->renderPartial('viewplan',['id'=>1,
                                             'model'    =>$planxtri,   
                                             'emp' => $emp,
                                             'trimestre'=> 1,
                                             'fectri'   =>'2016',
                                             'msg'      => '..',
                                             'idemp'    => $emp->idemp,
                                             'plana'=> $planaccion,
                                             'elementos'=> $elementos,   
                                              ]);
        
        $mpdf = new mpdf;
        $mpdf->WriteHTML($content);
        $mpdf->Output();
        */
    

    public function actionViewplan()
    {
         $msg = null;
        if(Yii::$app->request->post())
        {
            $fecini  = Html::encode($_POST["fecini"]);
            $fecfin  = Html::encode($_POST["fecfin"]);
            $idemp   = Html::encode($_POST["idemp"]);
        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $sqldatostri = " SELECT * FROM paaccion p 
            WHERE
                p.idemp = ".$idemp." AND
                fecini >= '".$fecini."' AND
                fecini <= '".$fecfin."' 
            UNION   
            SELECT * FROM paaccion 
            WHERE
                fecfin >= '".$fecini."' AND
                fecfin <= '".$fecfin."'   
            ORDER BY fecfin, feccre";

        $planaccion = Planaccion::find()
                    ->where(['idemp' => $idemp])
                    ->orderBy('orden')    
                    ->all();

        $connection = \Yii::$app->db;

        $modeltri = $connection->createCommand($sqldatostri);
        $planxtri = $modeltri->queryAll();

        $elementos  = Paaelemento::find()->where(['idpa' => $idemp])->all();

       
        $emp    = Empresa::findOne(['idemp' => $idemp]);
     
        return $this->render('viewplan', [
            'model'    => $planxtri,
            'msg'      => $msg,
            'idemp'    => $idemp,
            'emp'      => $emp, 
            'elementos'=> $elementos,
          //  'trimestre'=> $tr,  
            'plana'    => $planaccion,    
            'fectri'   => $fecini.' '.$fecfin, //Fechas de inicio de trimestre  
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
       ]
        );
    }


public function actionVentas()
    {
        $msg = null;
        if(Yii::$app->request->post())
        {
            $fecini  = Html::encode($_POST["fecini"]);
            $fecfin  = Html::encode($_POST["fecfin"]);
            $idemp   = Html::encode($_POST["idemp"]);
        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $model  = Facturah::find()
                ->joinWith(['idcli0'])
                ->where(['facturah.idemp' => $idemp, 
                         'facturah.estado' => 'Activa' ])
//                ->joinWith(['elementos'])
           //     ->where(['elemento.idemp' => $id])
                ->all();
            
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('ventas', [
            'model'   => $model,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
        ]);
    }


public function actionProductos()
    {
        $msg = null;
        if(Yii::$app->request->post())
        {
            $fecini  = Html::encode($_POST["fecini"]);
            $fecfin  = Html::encode($_POST["fecfin"]);
            $idemp   = Html::encode($_POST["idemp"]);
        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     


    $sqlpro = "SELECT p.nombre as nombre,sum(qty) as ctq,sum(fd.total) as vlr 
        FROM facturah fh, facturad fd, producto p
        WHERE 
            p.idemp = ".$idemp." AND
            fh.idfh = fd.idfh AND
            fd.idpro = p.idpro AND
            fh.estado = 'Activa' AND
            (fh.tipo = 'Pagada' or fh.tipo = 'Credito') AND
            fh.fecha >= '".$fecini."' AND
            fh.fecha <= '".$fecfin."'  
        GROUP BY p.nombre
        ORDER BY ctq desc";

        $connection = \Yii::$app->db;
        $modelpro = $connection->createCommand($sqlpro);
        $modelpro = $modelpro->queryAll();

        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('productos', [
            'model'   => $modelpro,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
        ]);
    }

    public function actionClientes(){
        
        if(Yii::$app->request->post())
        {
            $cliente = Html::encode($_POST["tipo"]);
            $idemp   = Html::encode($_POST["idemp"]);
        } else {
            $cliente = "Institucional";
        }

        //Si un usuario q no es adm Solo puede crear de su propia emp 
         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        if($cliente == "Todos"){
            $model = Cliente::find()
                ->where(['cliente.idemp' => $idemp])
                ->orderBy('tipo')
                ->all();
        
        }else{
            $model = Cliente::find()
                ->where(['cliente.idemp' => $idemp, 'tipo' => $cliente])
                ->all();
        }

        $emp    = Empresa::findOne(['idemp' => $idemp]);
        $dirtel = Dirtel::find()->where(['idemp'=> $idemp, 'tabla'=>'cliente'])->all();

          return $this->render('clientes', [
            'model'     => $model,
            'cliente'   => $cliente,
            'msg'       => null,
            'emp'       => $emp,
            'dirtel'    => $dirtel,
        ]);
    }

public function actionClientesproductos()
    {
        $msg = null;
        if(Yii::$app->request->post())
        {
            $fecini  = Html::encode($_POST["fecini"]);
            $fecfin  = Html::encode($_POST["fecfin"]);
            $idemp   = Html::encode($_POST["idemp"]);
        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     


    $sqlpro = "SELECT c.nombre1||' '||c.apellido1 as nom,
                      p.nombre as nombre, c.tipo,
                      sum(qty) as ctq, sum(fd.total) as vlr 
        FROM facturah fh, facturad fd, producto p,cliente c
        WHERE 
            p.idemp = ".$idemp." AND
            fh.idfh = fd.idfh AND
            fd.idpro = p.idpro AND
            fh.idcli = c.idcli AND
            fh.estado = 'Activa' AND
            (fh.tipo = 'Pagada' or fh.tipo = 'Credito') AND
            fh.fecha >= '".$fecini."' AND
            fh.fecha <= '".$fecfin."'  
        GROUP BY p.nombre, c.nombre1, c.apellido1, c.tipo
        ORDER BY c.tipo, ctq desc";

        $connection = \Yii::$app->db;
        $modelpro = $connection->createCommand($sqlpro);
        $modelpro = $modelpro->queryAll();

        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('clientesproductos', [
            'model'   => $modelpro,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
        ]);
    }


public function actionClientesfrecuencia()
    {
        $msg = null;
        if(Yii::$app->request->post())
        {
            $fecini  = Html::encode($_POST["fecini"]);
            $fecfin  = Html::encode($_POST["fecfin"]);
            $idemp   = Html::encode($_POST["idemp"]);
        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
    $sqlpro = "SELECT c.nombre1||' '||c.apellido1 as nom,
                      c.tipo, count(fh.idfh) as ct 
        FROM facturah fh, cliente c
        WHERE 
            fh.idemp = ".$idemp." AND
            fh.idcli = c.idcli AND
            fh.estado = 'Activa' AND
            (fh.tipo = 'Pagada' or fh.tipo = 'Credito') AND
            fh.fecha >= '".$fecini."' AND
            fh.fecha <= '".$fecfin."'  
        GROUP BY c.nombre1, c.apellido1, c.tipo
        ORDER BY c.tipo, ct desc";

        $connection = \Yii::$app->db;
        $modelpro = $connection->createCommand($sqlpro);
        $modelpro = $modelpro->queryAll();

        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('clientesfrecuencia', [
            'model'   => $modelpro,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
        ]);
    }

public function actionIndicadores()
    {
        $msg = null;
        if(Yii::$app->request->post())
        {
            $fecini  = Html::encode($_POST["fecini"]);
            $fecfin  = Html::encode($_POST["fecfin"]);
            $idemp   = Html::encode($_POST["idemp"]);
        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
        
        //***********INDICADOR 1
        $sqlin1 = "SELECT sum(total)  
            FROM facturah fh
            WHERE 
            fh.idemp = ".$idemp." AND
            fh.estado = 'Activa' AND
            (fh.tipo = 'Pagada' or fh.tipo = 'Credito') AND
            fh.fecha >= '".$fecini."' AND
            fh.fecha <= '".$fecfin."'  
             ";

        $connection = \Yii::$app->db;
        $in1 = $connection->createCommand($sqlin1);
        $in1 = $in1->queryScalar();

        //***********Indicador 2 AYUDA FER
         $sqlin2 = " SELECT sum(costo)
            FROM paaccion p 
            WHERE
                p.idemp = ".$idemp." AND
                fecini >= '".$fecini."' AND
                fecini <= '".$fecfin."' 
            UNION   
            SELECT sum(costo)
            FROM paaccion 
            WHERE
                fecfin >= '".$fecini."' AND
                fecfin <= '".$fecfin."'   
            ";
        $in2 = $connection->createCommand($sqlin2);
        $in2 = $in2->queryScalar();

        //***********INDICADOR 3
        $sqlin3 = "SELECT sum(idcli)  
            FROM cliente
            WHERE 
                idemp = ".$idemp." AND
                feccre >= '".$fecini."' AND
                feccre <= '".$fecfin."'  
             ";

        $in3 = $connection->createCommand($sqlin3);
        $in3 = $in3->queryScalar();
        $model = new facturad;
      
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('indicadores', [
            'in1'   => $in1,
            'in3'   => $in3,
            'model' => $model,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
        ]);
    }

    /**
     * Displays a single Planaccion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    
        $nomemp = Empresa::findOne(['idemp' => $model->idemp]);  
        $nomemp = strtoupper($nomemp->nombre);
       
        return $this->render('view', [
            'model'     => $model,
            'usumod'    => $usumod,
            'nomemp'    => $nomemp,

        ]);
    }


    /**
     * Creates a new Planaccion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Planaccion();
       
        $model->idemp   = $id;
        $model->usumod  = Yii::$app->user->identity->idusu;

        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $emp = Empresa::findOne(['idemp' => $id]);
        $estado = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado', 
                    'Pendiente'=>'Pendiente', 'Terminado'=>'Terminado'];  

        $fecha = date('Y.m.d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $emp->idemp]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'emp'   => $emp,
                'estado'  => $estado, 
                'fecha'   => $fecha,     
            ]);
        }
    }

    /**
     * Updates an existing Planaccion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        $estado = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado', 
                    'Pendiente'=>'Pendiente', 'Terminado'=>'Terminado'];  

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
                    

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpa]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'estado'  => $estado, 
                'emp'   => $emp,

            ]);
        }
    }

    /**
     * Deletes an existing Planaccion model.
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
     * Finds the Planaccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Planaccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Planaccion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
