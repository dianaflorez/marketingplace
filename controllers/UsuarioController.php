<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\Empresa;
use app\models\Tipo;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
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


 private function randKey($str='', $long=0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
  
 public function actionConfirm()
 {
    $table = new Usuario;
    if (Yii::$app->request->get())
    {
   
        //Obtenemos el valor de los parámetros get
        $id = Html::encode($_GET["id"]);
        $authKey = $_GET["authKey"];
    
        if ((int) $id)
        {
            //Realizamos la consulta para obtener el registro
            $model = $table
            ->find()
            ->where("id=:id", [":id" => $id])
            ->andWhere("authKey=:authKey", [":authKey" => $authKey]);
 
            //Si el registro existe
            if ($model->count() == 1)
            {
                $activar = Users::findOne($id);
                $activar->activate = 1;
                if ($activar->update())
                {
                    echo "Enhorabuena registro llevado a cabo correctamente, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al realizar el registro, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                }
             }
            else //Si no existe redireccionamos a login
            {
                return $this->redirect(["site/login"]);
            }
        }
        else //Si id no es un número entero redireccionamos a login
        {
            return $this->redirect(["site/login"]);
        }
    }
 }


    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);
       
        //Usuario que modifico
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    
       
        $nomemp = Empresa::findOne(['idemp' => $model->idemp]);  
        $nomemp = strtoupper($nomemp->nombre);

        $tipoidi = Tipo::findOne(['idtipo' => $model->idtide]);

        $role = "Comercial";
        if($model->role == 2){
            $role = "Administrador Empresa";
        }elseif ($model->role == 4) {
            $role = "Super Administrador";
        }
       
        return $this->render('view', [
            'model'     => $model,
            'usumod'    => $usumod,
            'nomemp'    => $nomemp,
            'role'      => $role,
            'tide'      => $tipoidi->nombre,
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();
        $model->activate = 1;

        $msg = "";

        $tipo = ArrayHelper::map(Tipo::find()->where(['tabla'=>'usuario'])->all(), 'idtipo', 'nombre');
        $emp  = ArrayHelper::map(Empresa::find()->andWhere('idemp>0')->all(), 'idemp', 'nombre');
        $role = ['1'=>'Comercial', '2'=>'Administrador Empresa', '4'=>'Super Administrador'];  

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            //return $this->redirect(['view', 'id' => $model->idusu]);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);    
        } 

/*
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

*/
            //Validación cuando el formulario es enviado vía post
            //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
            //También previene por si el usuario tiene desactivado javascript y la
            //validación mediante ajax no puede ser llevada a cabo
            if ($model->load(Yii::$app->request->post()))
            {
                
                if($model->validate())
               {
                    //Preparamos la consulta para guardar el usuario
                    $table = new Usuario;
                    $table->nombre1     = trim(ucwords($model->nombre1));
                    $table->nombre2     = trim(ucwords($model->nombre2));
                    $table->apellido1   = trim(ucwords($model->apellido1));
                    $table->apellido2   = trim(ucwords($model->apellido2));
                    $table->idtide      = $model->idtide;

                    $table->identificacion = $model->identificacion;
                    $table->username    = trim(strtolower($model->username));
                    $table->email       = trim(strtolower($model->email));
                    
                    //Encriptamos el password
                    $table->clave       = crypt($model->clave, Yii::$app->params["salt"]);
                    //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
                    //clave será utilizada para activar el usuario
                    $table->authkey     = $this->randKey("abcdef0123456789", 40);
                    //Creamos un token de acceso único para el usuario
                    $table->accesstoken = $this->randKey("abcdef0123456789", 40);
                
                    $table->role        = $model->role;
                    $table->estado      = 'Activo';   //Estado del usuario dependiendo del adm
                    $table->idemp       = $model->idemp;
                    $table->activate    = 1;       //Estado de activacion del usuario
                    $table->usumod      = Yii::$app->user->identity->idusu;
                    
                    //Si el registro es guardado correctamente
                    if ($table->save())
                    {
                        //Nueva consulta para obtener el id del usuario
                        //Para confirmar al usuario se requiere su id y su authKey
                        $user = $table->find()->where(["email" => $model->email])->one();
                        $id = urlencode($user->idusu);
                        $authkey = urlencode($user->authkey);
                          
                         $subject = "Confirmar registro";
                         $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
                         $body .= "<a href='http://yii.local/index.php?r=site/confirm&id=".$id."&authkey=".$authkey."'>Confirmar</a>";
                          
                         //Enviamos el correo
                         Yii::$app->mailer->compose()
                         ->setTo($user->email)
                         ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                         ->setSubject($subject)
                         ->setHtmlBody($body)
                         ->send();
                         
                         $model->nombre1 = null;
                         $model->apellido1 = null;
                         $model->clave = null;
                         $model->clave_repeat = null;
                         
                         //$msg = "Gracias, ahora sólo falta que confirmes tu registro en tu cuenta de correo";
                        $msg = "Su registro se realizo con exito";
                        
                    }else{
                        $msg = "Ha ocurrido un error al llevar a cabo tu registro";
                          echo "<br /><br /><br /><br /><br /><br /><br />";
                  // var_dump($table->getErrors());
                    }
                 
                }else{
                    var_dump( $model->getErrors() );
                }
            }
        return $this->render("create", ["model" => $model, 
                                        "msg"   => $msg, 
                                        "tipo"  => $tipo, 
                                        "emp"   => $emp,
                                        "role"  => $role
                                        ]);
      
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $msg = "";

        $tipo = ArrayHelper::map(Tipo::find()->all(), 'idtipo', 'nombre');
        $emp  = ArrayHelper::map(Empresa::find()->all(), 'idemp', 'nombre');
        $role = ['1'=>'Comercial', '2'=>'Gerente Empresa', '3'=>'Empresa', '4'=>'Administrador'];  


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idusu]);
        } else {
            return $this->render('update', [
                                        'model' => $model,
                                        "msg"   => $msg,
                                        "tipo"  => $tipo, 
                                        "emp"   => $emp,
                                        "role"  => $role 
                                    
                                ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
