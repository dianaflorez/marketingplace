<?php

namespace app\controllers;

use Yii;
use app\models\Planaccion;
use app\models\Paaelemento;
use app\models\Empresa;
use app\models\elemento;
use app\models\Accion;
use app\models\Usuario;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use mPDF;


/**
 * PlanaccionController implements the CRUD actions for Planaccion model.
 */
class PlanaccionController extends Controller
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
                   'actions' => ['view'],
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
     * Lists all Planaccion models.
     * @return mixed
     */
    public function actionIndex($id,$msg=null)
    {
     /*   $sqlplan = 
            "SELECT pa.idpa, pa.idemp,pa.nombre,pa.orden,a.idaccion,a.descripcion ades,
                    a.fecini,a.fecfin,    
                    a.orden,responsable,costo,estado, e.idele,e.descripcion,e.orden
            from 
                planaccion pa,
                paaccion a
            LEFT OUTER JOIN
                paaelemento e
            ON
                a.idaccion = e.idaccion
            WHERE
                pa.idemp = 2 AND
                pa.idpa = a.idpa
            ORDER BY pa.orden,a.orden";
        $connection = \Yii::$app->db;
        $modelpa = $connection->createCommand($sqlplan);
        $model = $modelpa->queryAll();
*/
         $model = Planaccion::find()
                ->where(['planaccion.idemp' => $id])
                ->joinWith(['paaccions'])
                ->joinWith(['paaelementos'])
                ->orderBy('planaccion.orden')
                ->all();
        //      $model = ArrayHelper::multisort($model,['paaccions.orden'],[SORT_ASC]);
     //         $model = ArrayHelper::toArray($model);
        $emp    = Empresa::findOne(['idemp' => $id]);

        return $this->render('index', [
            'model'   => $model,
            'msg'     => $msg,
            'idemp'   => $id,
            'emp'     => $emp, 
        ]);
    }

    public function actionViewplan($id, $tr = 1, $msg=null)
    {
       //Si un usuario q no es adm Solo puede ver su propia plan accion 
      if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
        else $idemp = $id;

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

        if( $tr == 2 ){
            $fecini = strtotime ( '+3 month' , strtotime ( $fecini ) ) ;
            $fecini = date ( 'Y-m-d' , $fecini);

            $fecfin = date('Y-m-d', strtotime("{$fecini} + 3 month"));
            $fecfin = date('Y-m-d', strtotime("{$fecfin} - 1 day"));
        }elseif( $tr == 3){
            $fecini = strtotime ( '+6 month' , strtotime ( $fecini ) ) ;
            $fecini = date ( 'Y-m-d' , $fecini);

            $fecfin = date('Y-m-d', strtotime("{$fecini} + 3 month"));
            $fecfin = date('Y-m-d', strtotime("{$fecfin} - 1 day"));
        }elseif( $tr == 4){
            $fecini = strtotime ( '+9 month' , strtotime ( $fecini ) ) ;
            $fecini = date ( 'Y-m-d' , $fecini);

            $fecfin = date('Y-m-d', strtotime("{$fecini} + 3 month"));
            $fecfin = date('Y-m-d', strtotime("{$fecfin} - 1 day"));
        }

        if( $tr >= 2 ){
            $sqldatostri = "SELECT idaccion, idemp, idpa, descripcion, orden, fecini, fecfin,responsable,costo,estado
                FROM paaccion p 
                WHERE
                p.idemp = 1 AND
                fecini <= '".$fecfin."' AND
                fecfin >= '".$fecini."'
                ORDER BY fecfin, feccre";
        }else{
            $sqldatostri = " SELECT idaccion, idemp, idpa, descripcion, orden, fecini, fecfin,responsable,costo,estado,feccre
                FROM paaccion p 
                WHERE
                    p.idemp = ".$id." AND
                    fecini >= '".$fecini."' AND
                    fecini <= '".$fecfin."' 
                UNION   
                SELECT idaccion, idemp, idpa, descripcion, orden, fecini, fecfin,responsable,costo,estado,feccre 
                FROM paaccion p
                WHERE
                    p.idemp = ".$id." AND
                    fecfin >= '".$fecini."' AND
                    fecfin <= '".$fecfin."'   
                ORDER BY fecfin, feccre";
        }

        $planaccion = Planaccion::find()
                    ->where(['idemp' => $id])
                    ->orderBy('orden')    
                    ->all();

        $elementos  = Paaelemento::find()->where(['idemp' => $id])->all();

        $modeltri = $connection->createCommand($sqldatostri);
        $planxtri = $modeltri->queryAll();

        $emp    = Empresa::findOne(['idemp' => $id]);
     
        return $this->render('viewplan', [
            'model'    => $planxtri,
            'msg'      => $msg,
            'idemp'    => $id,
            'emp'      => $emp, 
            'elementos'=> $elementos,
            'trimestre'=> $tr,  
            'plana'    => $planaccion,    
            'fecini'   => $fecini,
            'fecfin'   => $fecfin, 
        ]);
    }

  public function actionVerpdf($idemp)
    {
        
        $model = Planaccion::find()
                ->where(['planaccion.idemp' => $idemp])
                ->joinWith(['paaccions'])
                ->joinWith(['paaelementos'])
                ->orderBy('planaccion.orden')
                ->all();
        $emp    = Empresa::findOne(['idemp' => $idemp]);

       $content = $this->renderPartial('verpdf',[
                                            'model'   => $model,
                                            'idemp'   => $idemp,
                                            'emp'     => $emp, 
                                        ]);
        
        $mpdf = new mpdf('c', 'A4-L');
        $mpdf->WriteHTML($content);
        $mpdf->Output();
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
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
        else $idemp = $id;

        $model = new Planaccion();
       
        $model->idemp   = $id;
        $model->usumod  = Yii::$app->user->identity->idusu;

        //Si un usuario q no es adm Solo puede crear de su propia emp 
       if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $model->idemp = Yii::$app->user->identity->idemp;

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
