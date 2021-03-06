<?php

namespace app\controllers;

use Yii;
use app\models\Envioemail;
use app\models\Cliente;
use app\models\Empresainf;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use app\models\User;


/**
 * EnvioemailController implements the CRUD actions for Envioemail model.
 */
class EnvioemailController extends Controller
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
     * Lists all Envioemail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Envioemail::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Envioemail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $idemp, $idinf=null)
    {
         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $emp    = Empresa::findOne(['idemp' => $idemp ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'emp'   => $emp,
            'idinf' => $idinf,
        ]);
    }

    /**
     * Creates a new Envioemail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $idinf = null)
    {
        $msg = null;
        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $id = Yii::$app->user->identity->idemp;
     
        $model = new Envioemail();
        $model->idemp      = $id;
        $model->idusu      = Yii::$app->user->identity->idusu;

        $emp    = Empresa::findOne(['idemp' => $id]);

        $data = Cliente::find()
                ->where(['idemp' => $id])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          "email",
                          'idcli as id'])
                ->asArray()
                ->all();

        $swatt = 0;
        if($idinf != null) {
          $datos = Empresainf::findOne($idinf);
          $model->asunto = $datos->inf;
          if($datos->idtipo == 9 || $datos->idtipo == 15 || $datos->idtipo == 8){
            $model->contenido = $datos->inf;
            $ruta = $datos->descripcion;
            $swatt = 1;
          }else{
            $model->contenido = $datos->descripcion;
          }  
        }        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $subject = $model->asunto;
             $body = $model->contenido;
              
            if($swatt == 1){
                 //Enviamos el correo
               Yii::$app->mailer->compose()
               ->setTo($model->email)
               ->setFrom([Yii::$app->params["adminEmail"] => $emp->nombre])
               ->setSubject($subject)
               ->setHtmlBody($body)
               ->attach($ruta)
               ->send();  
            } else{
               //Enviamos el correo
               Yii::$app->mailer->compose()
               ->setTo($model->email)
               ->setFrom([Yii::$app->params["adminEmail"] => $emp->nombre])
               ->setSubject($subject)
               ->setHtmlBody($body)
               ->send();
            }   

            if($idinf != null) {
              return $this->redirect(['view', 'id'    => $model->idenv, 
                                              'idemp' => $emp->idemp,
                                              'idinf' => $idinf]);
            }else{
              return $this->redirect(['view', 'id'    => $model->idenv, 
                                              'idemp' => $emp->idemp,
                                              'idinf' => null]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'data'  => $data,
                'emp'   => $emp,
                'msg'   => $msg,
                'idinf' => $idinf,
            ]);
        }
    }

    /**
     * Updates an existing Envioemail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idenv]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Envioemail model.
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
     * Finds the Envioemail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Envioemail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Envioemail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
