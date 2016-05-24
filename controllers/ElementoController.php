<?php

namespace app\controllers;

use Yii;
use app\models\Elemento;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\AccessControl;
use app\models\User;

/**
 * ElementoController implements the CRUD actions for Elemento model.
 */
class ElementoController extends Controller
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
     * Lists all Elemento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Elemento::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Elemento model.
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
     * Creates a new Elemento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp, $idpa)
    {
         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $model = new Elemento();
        $model->idemp   = $idemp;
        $model->idpa    = $idpa;
        $model->usumod  = Yii::$app->user->identity->idusu;

        $emp = Empresa::findOne(['idemp' => $idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['planaccion/index', 'id' => $model->idemp]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'emp'   => $emp,
            ]);
        }
    }

    /**
     * Updates an existing Elemento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idele]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Elemento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
             $msg  = "Exito!!!";  
        if(Yii::$app->request->post())
        {
            $idemp     = Html::encode($_POST["idemp"]);
            $idele  = Html::encode($_POST["idele"]);

            if((int) $idemp)
            {
                if(Elemento::deleteAll("idele=:idele", [":idele" => $idele]))
                {
                    $msg = "Elemento con id $idele eliminado con éxito.";
                  ///  echo "<meta http-equiv='refresh' content='1; ".Url::toRoute("empresa/index")."'>";
                   return $this->redirect(["planaccion/index",'id' => $idemp, 'msg' => $msg]);
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar el Elemento redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute(["planaccion/index",'id' => $idemp, 'msg' => $msg])."'>"; 
                }
            }
            else
            {
                //echo "La empresa tiene informacion realacionada, no se puede eliminar, redireccionando ...";
             //   echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("empresa/index")."'>";
                $msg = "La empresa tiene informacion realacionada, no se puede eliminar";
                   return $this->redirect(["planaccion/index",'id' => $idemp, 'msg' => $msg]);
            }
        }
        else
        {
           return $this->redirect(["planaccion/index",'id' => $idemp, 'msg' => $msg]);
        }
    }

    /**
     * Finds the Elemento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Elemento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Elemento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
