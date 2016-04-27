<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Usuario;
use app\models\Empresa;
use app\models\Empresainf;
//Clases para upload
use app\models\FormUpload;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public $layout='/sinmenu';
    public function behaviors()
    {
      return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['logout', 'superAdmin', 'superMegaAdmin'],
            'rules' => [
                [
                    //El administrador tiene permisos sobre las siguientes acciones
                    'actions' => ['logout', 'superMegaAdmin'],
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
                   'actions' => ['logout', 'SuperAdmin'],
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
                    //El administrador tiene permisos sobre las siguientes acciones
                    'actions' => ['logout', 'AdminEmp'],
                    //Esta propiedad establece que tiene permisos
                    'allow' => true,
                    //Usuarios autenticados, el signo ? es para invitados
                    'roles' => ['@'],
                    //Este método nos permite crear un filtro sobre la identidad del usuario
                    //y así establecer si tiene permisos o no
                    'matchCallback' => function ($rule, $action) {
                        //Llamada al método que comprueba si es un administrador
                        return User::isAdminEmp(Yii::$app->user->identity->id);
                    },
                ],
                [
                    //El administrador tiene permisos sobre las siguientes acciones
                    'actions' => ['logout', 'Comercial'],
                    //Esta propiedad establece que tiene permisos
                    'allow' => true,
                    //Usuarios autenticados, el signo ? es para invitados
                    'roles' => ['@'],
                    //Este método nos permite crear un filtro sobre la identidad del usuario
                    //y así establecer si tiene permisos o no
                    'matchCallback' => function ($rule, $action) {
                        //Llamada al método que comprueba si es un administrador
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionSuperadmin(){
        $this->layout='main';
        return $this->render('superadmin');
    }

    public function actionSupermegaadmin(){
        $this->layout='main';
        return $this->render('superMegaAdmin');
    }

    public function actionAdminemp(){
        $this->layout='menuizq';
        $id = Yii::$app->user->identity->idemp;

        $modelemp = Empresa::findOne($id);
        $model    = Empresainf::find()->where(['idemp' => $id])->joinWith(['idtipo0'])->all();
      
        return $this->render('adminEmp', [
            'model'     => $model,
            'idemp'     => $id,
            'modelemp'  => $modelemp,
        ]);

    }

    public function actionComercial(){
        $this->layout='menuizq';
        $id = Yii::$app->user->identity->idemp;

        $modelemp = Empresa::findOne($id);
        $model    = Empresainf::find()->where(['idemp' => $id])->joinWith(['idtipo0'])->all();
      
        return $this->render('comercial', [
            'model'     => $model,
            'idemp'     => $id,
            'modelemp'  => $modelemp,
        ]);
    }

    public function actionDatos($msg = null){
        $this->layout='menuizq';

        $model = Usuario::findOne(Yii::$app->user->identity->idusu);
        $model->clave        = ""; 
        $model->clave_repeat = "";

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($model->clave == $model->clave_repeat ){
                
                if(!$model->clave_anterior){
                    return $this->redirect(['datos', 
                    'msg' => "No puede estar vacia la clave anterior"]);
                }else{    
                    $claveant = crypt($model->clave_anterior, Yii::$app->params["salt"]);

                    $verificar = Usuario::find()
                            ->where([
                            'idusu' =>Yii::$app->user->identity->idusu,
                            'clave' =>$claveant])
                            ->count();
                    
                    if($verificar){
                        $tabla = Usuario::findOne(Yii::$app->user->identity->idusu);
                        $tabla->clave = crypt($model->clave, Yii::$app->params["salt"]);
                        
                        if($tabla->save()){
                           return $this->redirect(['datos', 'msg' => "Datos actualizados exitosamente."]);
                        }else{
                            print_r($model->getErrors());

                        }
                    }else{
                    return $this->redirect(['datos', 
                        'msg' => "La clave anterior no es correcta"]);
                    }
                }
            }else{
                return $this->redirect(['datos', 
                    'msg' => "Las claves deben ser iguales"]);

            }    
        } else {
            return $this->render('datos', [
                                        'model' => $model,
                                        "msg"   => $msg,
                                    
                                ]);
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpload()
    {
         
         $model = new FormUpload;
         $msg = null;
         
         if ($model->load(Yii::$app->request->post()))
         {
            //PARA INPUT FILE SIMPLE
           /* $model->file = UploadedFile::getInstance($model, 'file');
              if ($model->file && $model->validate()) {
            
            $file = $model->file;
            $file->saveAs('archivos/' . $file->baseName . '.' . $file->extension);
            $msg = "<p><strong class='label label-info'>Siiippp, subida realizada con éxito</strong></p>";
            print_r($file->getErrors());
            }
*/
            //Para varios archivos   
            $model->file = UploadedFile::getInstances($model, 'file');
            
            if ($model->file && $model->validate()) {
               foreach ($model->file as $file) {
                $file->saveAs('archivos/' . $file->baseName . '.' . $file->extension);
                $msg = "<p><strong class='label label-info'>Subida realizada con éxito</strong></p>";
               }
            }
              
         }
         return $this->render("upload", ["model" => $model, "msg" => $msg]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {

            if (User::isSuperMegaAdmin(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/supermegaadmin"]);
            }
            elseif (User::isSuperAdmin(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/superadmin"]);
            }
            elseif (User::isAdminEmp(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/adminemp"]);
            }
            elseif (User::isComercial(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/comercial"]);
            }
            else 
            {
                return $this->redirect(["site/index"]);
            }
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if (User::isSuperMegaAdmin(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/supermegaadmin"]);
            } 
            elseif (User::isSuperAdmin(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/superadmin"]);
            }
            elseif (User::isAdminEmp(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/adminemp"]);
            }
            elseif (User::isComercial(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/comercial"]);
            }
           else
            {
                return $this->redirect(["site/index"]);
            }

        } else {
             return $this->render('login', [
                 'model' => $model,
             ]);
         }
     }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
