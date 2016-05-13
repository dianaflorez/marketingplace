<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use app\models\Usuario;
use app\models\Dirtel;
use app\models\Tipo;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\User;

use yii\helpers\Html;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
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
     * Lists all Cliente models.
     * @return mixed
     */
    public function actionIndex($idemp, $msg=null, $cliente='Institucional')
    {
        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        if(Yii::$app->request->post())
        {
          $idcli = Html::encode($_POST["cliente_id"]);
          if($idcli){
            $model = Cliente::find()
                  ->where(['cliente.idemp' => $idemp, 'idcli' => $idcli])
                  ->all();
          }else{
            $model = Cliente::find()
                  ->where(['cliente.idemp' => $idemp])
                  ->all();
          }
        }else{
          $model = Cliente::find()
            //      ->joinWith(['accions'])
                  ->where(['cliente.idemp' => $idemp, 'tipo' => $cliente])
            //      ->joinWith(['elementos'])
             //     ->where(['elemento.idemp' => $id])
                  ->all();
        }          
        
        $emp    = Empresa::findOne(['idemp' => $idemp]);
        $dirtel = Dirtel::find()->where(['idemp'=> $idemp, 'tabla'=>'cliente'])->all();

        $data = Cliente::find()
                ->where(['idemp' => $idemp])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          'idcli as id'])
                ->asArray()
                ->all();

          return $this->render('index', [
            'model'     => $model,
            'cliente'   => $cliente,
            'msg'       => $msg,
            'emp'       => $emp,
            'dirtel'    => $dirtel,
            'data'      => $data,
        ]);
    }

    /**
     * Displays a single Cliente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $emp   = Empresa::findOne(['idemp' => $model->idemp]);
        $tipoide   = Tipo::findOne(['idtipo' => $model->idtide]);
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    

        return $this->render('view', [
            'model' => $model,
            'emp'   => $emp,
            'usumod'=> $usumod,
            'tipoide' => $tipoide->nombre,
        ]);
    }

    /**
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp, $cliente )
    {
       if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $model = new Cliente();
        $model->idemp   = $idemp;
        $model->tipo    = $cliente; //tipo cliente 
        $model->usumod  = Yii::$app->user->identity->idusu;

        $msg = "";

        $tide = ArrayHelper::map(Tipo::find(['table' => 'usuario'])->all(), 'idtipo', 'nombre');
        $genero = ['Femenino'=>'Femenino', 'Masculino'=>'Masculino'];  
        $estado = ['Activo'=>'Activo', 'Inactivo'=>'Inactivo', 'Potencial'=>'Potencial'];  

        $emp = Empresa::findOne(['idemp' => $idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          
            return $this->redirect(['index', 'idemp' => $model->idemp, 'cliente' => $model->tipo]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'tide'  => $tide, 
                'msg'   => $msg,
                'genero'=> $genero,
                'tipo'  => $cliente,
                'estado'=> $estado,
                'emp'   => $emp,
                'cliente' => $cliente,
            ]);
        }
    }

    /**
     * Updates an existing Cliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;
        $msg = "";

        $tipocli = $model->tipo;

        $tide = ArrayHelper::map(Tipo::find(['table' => 'usuario'])->all(), 'idtipo', 'nombre');
        $genero = ['Femenino'=>'Femenino', 'Masculino'=>'Masculino'];  
        $estado = ['Activo'=>'Activo', 'Inactivo'=>'Inactivo'];  

        $emp    = Empresa::findOne(['idemp' => $model->idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcli]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tide'  => $tide, 
                'msg'   => $msg,
                'genero'=> $genero,
                'tipo'  => $tipocli,
                'estado'=> $estado,
                'cliente'=> $tipocli,
                'emp'   => $emp,
            ]);
        }
    }

    /**
     * Deletes an existing Cliente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->estado = "Inactivo";
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;
        $msg = "";

        $emp    = Empresa::findOne(['idemp' => $model->idemp]);
        
        $model->save();
        return $this->redirect(['index', 'idemp' => $model->idemp, 'cliente' => $model->tipo]);
        
    }

    /**
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
