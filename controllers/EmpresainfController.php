<?php

namespace app\controllers;

use Yii;
use app\models\Empresainf;
use app\models\Empresa;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Tipo;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
//Clases para upload
use app\models\FormUpload;
use yii\web\UploadedFile;

/**
 * EmpresainfController implements the CRUD actions for Empresainf model.
 */
class EmpresainfController extends Controller
{
    /**
     * @inheritdoc
     */

   // public     $layout='menuizq';

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
                   'actions' => ['index'],
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
     * Lists all Empresainf models.
     * @return mixed
     */
    public function actionIndex($id)
    {

       if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $id = Yii::$app->user->identity->idemp;
     
        $modelemp = Empresa::findOne($id);
        $model    = Empresainf::find()
                    ->where(['idemp' => $id])
                    ->joinWith(['idtipo0'])
                    ->orderBy('tipo.orden')
                    ->all();

        $urllogo  = Empresainf::findOne(['idemp' => $id, 'idtipo' => 10]);

        if($urllogo)
            $urllogo = $urllogo->descripcion;
        else
            $urllogo = "0";

        return $this->render('index', [
            'model'     => $model,
            'idemp'     => $id,
            'modelemp'  => $modelemp,
            'urllogo'   => $urllogo,
        ]);
    }

    /**
     * Displays a single Empresainf model.
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
     * Creates a new Empresainf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp)
    {
        $model = new Empresainf();
       
        $tipos          = Tipo::find()->where(['tabla' => 'empresainf'])->all();
        $tipo           = ArrayHelper::map($tipos, 'idtipo', 'nombre');
        $model->idemp   = $idemp;

        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $model->idemp = Yii::$app->user->identity->idemp;
     
        $modelemp   = Empresa::findOne($model->idemp);

        $model->usumod = Yii::$app->user->identity->idusu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->idemp]);
        } else {
            return $this->render('create', [
                'model'     => $model,
                'tipo'      => $tipo,
                'modelemp'  => $modelemp,
            ]);
        }
    }

    /**
     * Updates an existing Empresainf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $tipos          = Tipo::find()->where(['tabla' => 'empresainf'])->all();
        $tipo           = ArrayHelper::map($tipos, 'idtipo', 'nombre');

        $modelemp   = Empresa::findOne($model->idemp);
        
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->idemp]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tipo'      => $tipo,
                'modelemp'  => $modelemp,
            ]);
        }
    }

    public function actionLogo($idemp, $doc, $new = null)
    {
         $model = new FormUpload;
         $msg = null;
         
         if ($model->load(Yii::$app->request->post()))
         {
             if(Yii::$app->user->identity->role != 4 &&   
                Yii::$app->user->identity->role != 7)
                $idemp = Yii::$app->user->identity->idemp;
            
            //Para varios archivos   
            $model->file = UploadedFile::getInstances($model, 'file');
            
            $sw = 0; //Si suben mas de un arc solo guarda el primero
            
            if ($model->file && $model->validate()) {

               foreach ($model->file as $file) {
                $urldestino = 'archivos/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($urldestino);
                $msg = "<p><strong class='label label-info'>Subida realizada con éxito</strong></p>";
            if($doc == 0 && $sw == 0 && $new == null){ $sw = 1;

                $ctlogo = Empresainf::find()
                                ->where(['idemp' => $idemp, 'idtipo' => 10])
                                ->count();

                if($ctlogo < 1){
                    $tabla = new Empresainf;
                    $tabla->idemp = $idemp;
                    $tabla->idtipo  = 10; //De la tabla tipo = Logo
                    $tabla->inf   = "logo"; 
                    $tabla->descripcion = $urldestino;
                    $tabla->usumod      = Yii::$app->user->identity->idusu;
                    $tabla->save();
                }
               // echo "<br /><br /><br />";
               // print_r($tabla->getErrors());
            }elseif($doc !=0 && $sw == 0 && $new == null){
                $sw = 1;
                $tabla = Empresainf::findOne(['idinf' => $doc, 'idemp' => $idemp ]);
                if($tabla){
                    $tabla->descripcion = $urldestino;
                    $tabla->fecmod = date('Y.m.d h:i:s');
                    $tabla->usumod = Yii::$app->user->identity->idusu;
                    $tabla->save();    
                }
            }elseif($new == 15 && $sw == 0){
                $sw = 1;
                $tabla = new Empresainf;  
                $tabla->idemp = $idemp;
                $tabla->idtipo  = 15; //De la tabla tipo = Otro
                $tabla->inf     = $model->info; 
                $tabla->descripcion = $urldestino;
                $tabla->usumod      = Yii::$app->user->identity->idusu;
                $tabla->save();
           
                //print_r($tabla->getErrors());

            }
                return $this->redirect(['index', 'id' => $idemp]);
            
               }//foreach
            }
         }
         return $this->render("logo", ["model" => $model, "msg" => $msg, "new" => $new]);
    }

    /**
     * Deletes an existing Empresainf model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        //$this->findModel($id)->delete();
      //  return $this->redirect(['index']);

        if(Yii::$app->request->post())
        {
            $idinf = Html::encode($_POST["idinf"]);
            $idemp = Html::encode($_POST["idemp"]);
            if((int) $idemp)
            {
                if(Empresainf::deleteAll("idinf=:idinf", [":idinf" => $idinf]))
                {
                    echo "La informacion de la empresa con id $idinf eliminada con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='1; ".
                    Url::toRoute(["empresainf/index", "id" => $idemp])."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar la Empresa redireccionando ...";
                    echo "<meta http-equiv='refresh' content='1; ".Url::toRoute(["empresainf/index", "id" => $idemp])."'>"; 
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar la empresa, redireccionando ...";
                echo "<meta http-equiv='refresh' content='2; ".Url::toRoute(["empresainf/index", "id" => $idemp])."'>";
            }
        }
        else
        {
            return $this->redirect(["empresainf/index"]);
        }
    }

    /**
     * Finds the Empresainf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresainf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresainf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
