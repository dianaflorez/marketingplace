<?php

namespace app\controllers;

use Yii;
use app\models\Pmcontenido;
use app\models\Usuario;
use app\models\Empresa;
use app\models\Planmarketing;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;

/**
 * PmcontenidoController implements the CRUD actions for Pmcontenido model.
 */
class PmcontenidoController extends Controller
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
                   'actions' => ['index','view'],
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
     * Lists all Pmcontenido models.
     * @return mixed
     */
    public function actionIndex($id,$activo)
    {
       if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $id = Yii::$app->user->identity->idemp;
        
        $emp = Empresa::findOne(['idemp' => $id]);
        $pm1 = Planmarketing::findOne(['idemp' => $id,'orden' =>1]);
        $pm2 = Planmarketing::findOne(['idemp' => $id,'orden' =>2]);

        $pm3 = Pmcontenido::find()
               ->joinWith(['idpm0'])
               ->orderBy('pmcontenido.orden')
               ->where(['idemp' => $id,'planmarketing.orden' =>3])
               ->all();
        
        $pm4 = Pmcontenido::find()
               ->joinWith(['idpm0'])
               ->orderBy('pmcontenido.orden')
               ->where(['idemp' => $id,'planmarketing.orden' =>4])
               ->all();

        $pm4id = Planmarketing::findOne(['idemp' => $id,'orden' =>4]);
            
        return $this->render('index', [
            'pm1'   => $pm1,
            'pm2'   => $pm2,
            'pm3'   => $pm3,
            'pm4'   => $pm4,
            'emp'   => $emp,
            'activo'=> $activo,
            'pm4id' => $pm4id->idpm,
        ]);
    }


    /**
     * Displays a single Pmcontenido model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $activo)
    {
        $model  = $this->findModel($id);
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);   

        $pm = Planmarketing::findOne(['idpm'=> $model->idpm]); 

        return $this->render('view', [
            'model'     => $model,
            'usumod'    => $usumod,
            'pm'        => $pm,
            'activo'    => $activo,
        ]);
    }

    /**
     * Creates a new Pmcontenido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $idemp, $activo, $cont)
    {
        $model = new Pmcontenido();
        $model->idpm    = $id;
        $model->titulo  = $cont;
        $model->usumod  = Yii::$app->user->identity->idusu;
     
        if($cont == "Objetivo") {
            $ct = Pmcontenido::find()->where(['idpm' => $id, 'titulo'=>'Objetivo'])->count();
            $model->orden = $ct + 1;
        }

       if($cont == "Estrategia") {
            $ct = Pmcontenido::find()->where(['idpm' => $id, 'titulo'=>'Estrategia'])->count();
            $model->orden = $ct + 1;
        }

        $emp = Empresa::findOne(['idemp' => $idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $emp->idemp, 'activo' => $activo]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'cont'  => $cont,
                'emp'   => $emp,
                'tab'   => $activo,
            ]);
        }
    }

    /**
     * Updates an existing Pmcontenido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$idemp, $activo)
    {
       if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;

        $emp = Empresa::findOne(['idemp' => $idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $emp->idemp, 'activo' => $activo]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'emp'   => $emp,
                'tab'   => $activo,
            ]);
        }
    }

    /**
     * Deletes an existing Pmcontenido model.
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
     * Finds the Pmcontenido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pmcontenido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pmcontenido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
