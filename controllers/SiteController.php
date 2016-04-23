<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Empresa;
use app\models\Empresainf;


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
        return $this->render('comercial');
    }

    public function actionIndex()
    {
        return $this->render('index');
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
