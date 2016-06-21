<?php

namespace app\controllers;

use Yii;
use app\models\Cita;
use app\models\Empresa;
use app\models\Usuario;
use app\models\Cliente;
use app\models\Citapedido;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\User;
//Para encode
use yii\helpers\Html;
use yii\data\Pagination;

/**
 * CitaController implements the CRUD actions for Cita model.
 */
class CitaController extends Controller
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
     * Lists all Cita models.
     * @return mixed
     */
    public function actionIndex($idemp, $msg=null)
    {
        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
        
        if(Yii::$app->request->post())
        {
          //  $idemp  = Html::encode($_POST["idemp"]);
            if($_POST["cliente_id"] || $_POST["fecini"] || $_POST["estado"]){

                $idcli  = null;
                $fecini = null;
                $fecfin = null;
                $estado = null;

                if($_POST["cliente_id"] && $_POST["fecini"] && 
                   $_POST["fecfin"] && $_POST["estado"]){

                    $idcli   = Html::encode($_POST["cliente_id"]);
                    $fecini  = Html::encode($_POST["fecini"]);
                    $fecfin  = Html::encode($_POST["fecfin"]);
                    $estado  = Html::encode($_POST["estado"]);

                    $table = Cita::find()
                        ->joinWith(['idcli0'])
                        ->where(['cita.idemp' => $idemp, 'cita.estado' => $estado])
                        ->andWhere(["=", 'cita.idcli', $idcli])
                        ->andWhere([">=", 'cita.fecha', $fecini])
                        ->andwhere(["<=", 'cita.fecha', $fecfin]);

                }elseif($_POST["cliente_id"]){

                    $idcli   = Html::encode($_POST["cliente_id"]);
                    $table = Cita::find()
                        ->joinWith(['idcli0'])
                        ->where(['cita.idemp' => $idemp])
                        ->andWhere(["=", 'cita.idcli', $idcli]);

                }elseif($_POST["fecini"] && $_POST["fecfin"] ){
                    $fecini  = Html::encode($_POST["fecini"]);
                    $fecfin  = Html::encode($_POST["fecfin"]);
                    $msg = "Resultados con fecha inicial ".$fecini." y fecha final ".$fecfin;
                    $table = Cita::find()
                        ->joinWith(['idcli0'])
                        ->where(['cita.idemp' => $idemp])
                        ->andWhere([">=", 'cita.fecha', $fecini])
                        ->andWhere(["<=", 'cita.fecha', $fecfin]);
                
                }elseif($_POST["fecini"]){
                    $fecini  = Html::encode($_POST["fecini"]);
                    $msg = "Resultados con fecha inicial ".$fecini;
                    $table = Cita::find()
                        ->joinWith(['idcli0'])
                        ->where(['cita.idemp' => $idemp])
                        ->andWhere([">=", 'cita.fecha', $fecini]);
                 
                }elseif($_POST["estado"]){
                    $estado  = Html::encode($_POST["estado"]);
                    $msg = "Resultados con estado ".$estado;
                 
                    $table = Cita::find()
                        ->joinWith(['idcli0'])
                        ->where(['cita.idemp' => $idemp, 'cita.estado' => $estado]);
           
                }else{
                    $table = Cita::find()
                        ->joinWith(['idcli0'])
                        ->where(['cita.idemp' => $idemp]);
                }                          

                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 10,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->orderBy('fecha desc')
                        ->all();
            }else{
               $table  = Cita::find()
                    ->joinWith(['idcli0'])
                    ->where(['cita.idemp' => $idemp]);
                   
                $count = clone $table;
                $pages = new Pagination([
                        "pageSize" => 10,
                        "totalCount" => $count->count()
                    ]);
                $model = $table
                  ->offset($pages->offset)
                  ->limit($pages->limit)
                  ->orderBy('fecha desc')
                  ->all();
            }                 
        }else{
        
            $table  = Cita::find()
                    ->joinWith(['idcli0'])
                    ->where(['cita.idemp' => $idemp]);
               
            $count = clone $table;
            $pages = new Pagination([
                    "pageSize" => 10,
                    "totalCount" => $count->count()
                ]);
            $model = $table
              ->offset($pages->offset)
              ->limit($pages->limit)
              ->orderBy('fecha desc')
              ->all();

        }

        $data = Cliente::find()
                ->where(['idemp' => $idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();
                     
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        $pedidos = Citapedido::find()->where(['idemp' => $idemp])->all();

        return $this->render('index', [
            'model' => $model,
            'emp'   => $emp,
            'msg'   => $msg,
            'pedidos'=> $pedidos,
            'data'  => $data,
            "pages"         => $pages,
            
        ]);
    }

    /**
     * Displays a single Cita model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $emp   = Empresa::findOne(['idemp' => $model->idemp]);
       
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    

        $nomcli = Cliente::findOne(['idcli' => $model->idcli]);
        $nomcli = ucwords($nomcli->nombre1.' '.$nomcli->apellido1);    

        return $this->render('view', [
            'model' => $model,
            'emp'   => $emp,
            'usumod'=> $usumod,
            'nomcli'=> $nomcli,
        ]);
    }

    /**
     * Creates a new Cita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp)
    {
        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $emp    = Empresa::findOne(['idemp' => $idemp]);
 
        $model = new Cita();
        $model->idemp = $idemp;
        $model->idusu  = Yii::$app->user->identity->idusu;
        $model->usumod  = Yii::$app->user->identity->idusu;

        $estado = ['Pendiente'=>'Pendiente', 'Cumplido'=>'Cumplido', 'Aplazado' => 'Aplazado'];  
        
        $clientes   = ArrayHelper::map(Cliente::find()
                        ->where(['idemp' => $model->idemp])->all(), 'idcli', 'nombre1');
        $data = Cliente::find()
                ->where(['idemp' => $idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcita]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'emp'   => $emp,
                'estado'=> $estado,
                'data' => $data,
            ]);
        }
    }

    /**
     * Updates an existing Cita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $idemp)
    {
        //Si un usuario q no es adm Solo puede crear de su propia emp 
         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->idusu  = Yii::$app->user->identity->idusu;

        $emp   = Empresa::findOne(['idemp' => $idemp]);

        $estado = ['Pendiente'=>'Pendiente', 'Cumplido'=>'Cumplido', 'Aplazado' => 'Aplazado'];  

        $clientes   = ArrayHelper::map(Cliente::find()
                        ->where(['idemp' => $model->idemp])->all(), 'idcli', 'nombre1');
     
        $data = Cliente::find()
                ->where(['idemp' => $idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();
 
        $cliente   = Cliente::findOne(['idcli' =>$model->idcli]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcita]);
        } else {
            return $this->render('update', [
                'model'     => $model,
                'estado'    => $estado,
                'emp'       => $emp,
                'data'      => $data,
                'cliente'   => $cliente,
            ]);
        }
    }

    /**
     * Deletes an existing Cita model.
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
     * Finds the Cita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
