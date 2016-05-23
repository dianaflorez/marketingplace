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

        if(!$mesinicial) $mesinicial = date('m');

        $sqlyear = "SELECT date_part('year', MIN(fecini)) as anio FROM paaccion WHERE idemp = ".$idemp;
        $modelyear = $connection->createCommand($sqlyear);
        $year = $modelyear->queryScalar();

        if(!$year) $year = date('Y');

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
    

    public function actionViewplan($pdf = null)
    {
        $msg = null;
        $btn = 1;
        if(Yii::$app->request->post())
        {
            $fecini  = Html::encode($_POST["fecini"]);
            $fecfin  = Html::encode($_POST["fecfin"]);
            $idemp   = Html::encode($_POST["idemp"]);
            $btn     = Html::encode($_POST["btn"]);
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
            SELECT * FROM paaccion p
            WHERE
                p.idemp = ".$idemp." AND
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

        $elementos  = Paaelemento::find()->where(['idemp' => $idemp])->all();

       
        $emp    = Empresa::findOne(['idemp' => $idemp]);
        if($btn == 2){

          $content = $this->renderPartial('viewplanpdf', [
                    'model'    => $planxtri,
                    'msg'      => $msg,
                    'idemp'    => $idemp,
                    'emp'      => $emp, 
                    'elementos'=> $elementos,
                    'plana'    => $planaccion,    
                    'fectri'   => $fecini.' '.$fecfin, //Fechas de inicio de trimestre  
                    'fecini'   => $fecini,
                    'fecfin'   => $fecfin, 
                ]);        
            $mpdf = new mpdf('c', 'A4-L');
            $mpdf->WriteHTML($content);
            $mpdf->Output();
        }
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
                ->andWhere([">=", 'facturah.fecha', $fecini])
                ->andwhere(["<=", 'facturah.fecha', $fecfin])

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
        
      //Si un usuario q no es adm Solo puede crear de su propia emp 
         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        if(Yii::$app->request->post())
        {
            if(isset($_POST["btn"])) 
                $btn  = Html::encode($_POST["btn"]);
            else $btn = 0;

            $cliente = Html::encode($_POST["tipo"]);
            $idemp   = Html::encode($_POST["idemp"]);
            

        } else {
            $cliente = "Todos";
        }

     
        if($cliente == "Todos"){
            $model = Cliente::find()
                ->where(['cliente.idemp' => $idemp])
                ->orderBy('tipo,estado desc')
                ->all();
        
        }else{
            $model = Cliente::find()
                ->where(['cliente.idemp' => $idemp, 'tipo' => $cliente])
                ->orderBy('tipo,estado desc')
                ->all();
        }

        $emp    = Empresa::findOne(['idemp' => $idemp]);
        $dirtel = Dirtel::find()->where(['idemp'=> $idemp, 'tabla'=>'cliente'])->all();

        if($btn == 2){

          $content = $this->renderPartial('clientespdf', [
                'model'     => $model,
                'cliente'   => $cliente,
                'msg'       => null,
                'emp'       => $emp,
                'dirtel'    => $dirtel,
                ]);        
            $mpdf = new mpdf();
            $mpdf->addPage('p','Letter');
            $mpdf->WriteHTML($content);
            $mpdf->Output();
        }

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
            $tipo    = Html::encode($_POST["tipo"]);
        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     

        if($tipo != "Todos"){
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
                fh.fecha <= '".$fecfin."' AND
                c.tipo = '".$tipo."' 
            GROUP BY p.nombre, c.nombre1, c.apellido1, c.tipo
            ORDER BY vlr desc,c.tipo, ctq desc";
        }else{  
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
            ORDER BY vlr desc,c.tipo, ctq desc";
        }
            
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
            $tipo    = Html::encode($_POST["tipo"]);
            $cliente = Html::encode($_POST["cliente_id"]);

        } else {
            $fecini = date('Y-m-d');
            $fecfin = date('Y-m-d');
        }

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        if($tipo != "Todos"){
            $sqlpro = "SELECT c.nombre1||' '||c.apellido1 as nom,
                          c.tipo, count(fh.idfh) as ct 
            FROM facturah fh, cliente c
            WHERE 
                fh.idemp = ".$idemp." AND
                fh.idcli = c.idcli AND
                fh.estado = 'Activa' AND
                (fh.tipo = 'Pagada' or fh.tipo = 'Credito') AND
                fh.fecha >= '".$fecini."' AND
                fh.fecha <= '".$fecfin."' AND
                c.tipo = '".$tipo."'  
            GROUP BY c.nombre1, c.apellido1, c.tipo
            ORDER BY c.tipo, ct desc";
        }else{
            if($cliente){
                $sqlpro = "SELECT c.nombre1||' '||c.apellido1 as nom,
                              c.tipo, count(fh.idfh) as ct 
                FROM facturah fh, cliente c
                WHERE 
                    fh.idemp = ".$idemp." AND
                    fh.idcli = c.idcli AND
                    fh.estado = 'Activa' AND
                    (fh.tipo = 'Pagada' or fh.tipo = 'Credito') AND
                    fh.fecha >= '".$fecini."' AND
                    fh.fecha <= '".$fecfin."' AND
                    c.idcli = '".$cliente."' 
                GROUP BY c.nombre1, c.apellido1, c.tipo
                ORDER BY c.tipo, ct desc";
            }else{
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
            }
        }

        $connection = \Yii::$app->db;
        $modelpro = $connection->createCommand($sqlpro);
        $modelpro = $modelpro->queryAll();

        $emp    = Empresa::findOne(['idemp' => $idemp]);
        
        $data = Cliente::find()
                ->where(['idemp' => $idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();

        return $this->render('clientesfrecuencia', [
            'model'   => $modelpro,
            'msg'     => $msg,
            'idemp'   => $idemp,
            'emp'     => $emp, 
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
            'data'     => $data, 
        ]);
    }
 public function actionIndicadorfec($fec, $id) {
        $sqlin4 = "SELECT count(idcli)  
            FROM cliente
            WHERE 
                idemp = ".$id." AND
                feccre <= '".$fec."'  
             ";
        $connection = \Yii::$app->db;

        $in4 = $connection->createCommand($sqlin4);
        $in = $in4->queryScalar();
        
        return $in;
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

        //***********Indicador 2 
         $sqlin2 = " select sum(foo.costo) from 
                (SELECT costo
                FROM paaccion p 
                WHERE
                    p.idemp = ".$idemp." AND
                    fecini >= '".$fecini."' AND
                    fecini <= '".$fecfin."' 
                UNION 
                SELECT costo
                FROM paaccion p
                WHERE
                    p.idemp = ".$idemp." AND
                    fecfin >= '".$fecini."' AND
                    fecfin <= '".$fecfin."') as foo   
                ";
        $in2 = $connection->createCommand($sqlin2);
        $in2 = $in2->queryScalar();

        //***********INDICADOR 3  TOTAL CLIENTE EMPRESA
        $sqlin3 = "SELECT count(idcli)  
            FROM cliente
            WHERE 
                idemp = ".$idemp."   
             ";

        $in3 = $connection->createCommand($sqlin3);
        $in3 = $in3->queryScalar();

        //***********INDICADOR 4
        $sqlin4 = "SELECT count(idcli)  
            FROM cliente
            WHERE 
                idemp = ".$idemp." AND
                feccre >= '".$fecini."' AND
                feccre <= '".$fecfin."'  
             ";

        $in4 = $connection->createCommand($sqlin4);
        $in4 = $in4->queryScalar();
        
        //***********INDICADOR 5  NO ESTA TERMINADA
        $sqlin5 = "SELECT count(*) FROM
                (SELECT c.idcli, count(c.idcli) as ct
                FROM cliente c, facturah fh
                WHERE 
                    c.idcli = fh.idcli AND
                    c.idemp = ".$idemp." AND
                    fecha >= '".$fecini."' AND
                    fecha <= '".$fecfin."'  
                GROUP BY c.idcli) as foo
                WHERE foo.ct > 1
             ";

        $in5 = $connection->createCommand($sqlin5);
        $in5 = $in5->queryScalar();

        $in51 = ($in5/$in3) * 100;
        
        //***********INDICADOR 6
        $sqlin6 = "SELECT sum(idcli)  
            FROM cliente
            WHERE 
                idemp = ".$idemp." AND
                feccre >= '".$fecini."' AND
                feccre <= '".$fecfin."'  
             ";

        $in6 = $connection->createCommand($sqlin6);
        $in6 = $in6->queryScalar();
        

        $model = new facturad;
      
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('indicadores', [
            'in1'   => $in1,
            'in2'   => $in2,
            'in3'   => $in3,
            'in4'   => $in4,
            'in5'   => $in5,
            'in51'   => $in51,
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
