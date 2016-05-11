<?php

namespace app\controllers;

use Yii;
use app\models\Paaccion;
use app\models\Empresa;
use app\models\Usuario;
use app\models\Planaccion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

use yii\filters\AccessControl;
use app\models\User;
/**
 * PaaccionController implements the CRUD actions for Paaccion model.
 */
class PaaccionController extends Controller
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
                   'actions' => ['index', 'view'],
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
     * Lists all Paaccion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Paaccion::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paaccion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    
        $emp = Empresa::findOne(['idemp' => $model->idemp]);  
        
        return $this->render('view', [
            'model'     => $model,
            'usumod'    => $usumod,
            'emp'       => $emp,

        ]);
    }

    /**
     * Creates a new Paaccion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idpa, $idemp,$pa)
    {
       if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;

        $ctorden = Paaccion::find()->where(['idemp'=>$idemp,'idpa'=>$idpa])->count();    
      
        $model = new Paaccion();
        $model->idemp   = $idemp;
        $model->idpa    = $idpa;
        $model->orden   = $ctorden + 1;
        $model->usumod  = Yii::$app->user->identity->idusu;

        //Si un usuario q no es adm Solo puede crear de su propia emp 
       if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $model->idemp = Yii::$app->user->identity->idemp;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
        $estado = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado', 
                    'Pendiente'=>'Pendiente', 'Terminado'=>'Terminado'];  

        $fecha = date('Y.m.d');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['planaccion/index', 'id' => $model->idemp, 'pa'=>$pa]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'emp'   => $emp,
                'estado'=> $estado, 
                'fecha' => $fecha,     
                'pa'    => $pa,
            ]);
        }
    }

    /**
     * Updates an existing Paaccion model.
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
            return $this->redirect(['planaccion/index', 'id' => $emp->idemp]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'estado'  => $estado, 
                'emp'   => $emp,
             ]);
        }
    }

    public function actionUpdateplantilla()
    {
      if(Yii::$app->user->identity->role != 4 &&   
         Yii::$app->user->identity->role !=7)
            $idemp = Yii::$app->user->identity->idemp;
      
        if(Yii::$app->request->post())
        {
            $idaccion = Html::encode($_POST["idaccion"]);
            $desc     = Html::encode($_POST["desc"]);
            $fecini   = Html::encode($_POST["fecini"]);
            $fecfin   = Html::encode($_POST["fecfin"]);
            $responsable   = Html::encode($_POST["responsable"]);
            $costo    = Html::encode($_POST["costo"]);
            $estado   = Html::encode($_POST["estado"]);
            $idemp    = Html::encode($_POST["idemp"]);

            if(strtotime($fecfin) < strtotime($fecini)) $fecfin = $fecini;

            $model = $this->findModel($idaccion);
            $model->descripcion = trim($desc);
            $model->fecini      = $fecini;
            $model->fecfin      = $fecfin;
            $model->responsable = trim($responsable);
            $model->costo       = trim($costo);
            $model->estado      = trim($estado);
            $model->fecmod      = date('Y.m.d h:i:s');
            $model->usumod      = Yii::$app->user->identity->idusu;
 
            if ($model->save()) {
            //  var_dump($model->getErrors());
           //   echo $model->descripcion;
                return $this->redirect(['planaccion/index', 'id' => $idemp]);
            } 

        } else {
      
            return $this->render('planaccion/index', [
                'id'   => $idemp,
             ]);
        }
    }

    /**
     * Deletes an existing Paaccion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

        $id  = Html::encode($_POST["idaccion"]);

        $model = $this->findModel($id);
        $model->estado = "Anulado";
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        $estado = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado', 
                    'Pendiente'=>'Pendiente', 'Terminado'=>'Terminado'];  

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
       
        $model->save();
        return $this->redirect(['planaccion/index', 'id' => $model->idemp]);
    }

    /**
     * Finds the Paaccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paaccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paaccion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
