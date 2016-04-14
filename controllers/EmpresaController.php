<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use app\models\Empresainf;
use app\models\User;
use yii\filters\AccessControl;
use app\models\EmpresaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\EmpresaSearchForm;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;
use app\models\Usuario;
use app\models\Planmarketing;
use app\models\Pmcontenido;
use yii\web\Response;


/**
 * EmpresaController implements the CRUD actions for Empresa model.
 */
class EmpresaController extends Controller
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
     * Lists all Empresa models.
     * @return mixed
     */
    public function actionIndex($msg)
    {
     //   $searchModel = new EmpresaSearch;
     //   $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
       // $table = new Empresa;
        //$model = $table->find()->andWhere('idemp>1')->all();

        $form = new EmpresaSearchForm;
        $search = null;
        if($form->load(Yii::$app->request->get()))
        {
             if ($form->validate())
            {
                $search = Html::encode($form->q);
                $table = Empresa::find()
                        ->andWhere('idemp>0')
                        ->orWhere(["like", "nombre", $search])
                        ->orWhere(["like", "nit", $search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 3,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
            }
            else
            {
                $form->getErrors();
            }
        }else{
                $table = Empresa::find()->andWhere('idemp>0');
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 4,
                    "totalCount" => $count->count(),
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        }

        return $this->render('index', [
         //   'searchModel'   => $searchModel,
          //  'dataProvider'  => $dataProvider,
            'model'         => $model,
            "form"          => $form, 
            "search"        => $search,
            "pages"         => $pages,
            "msg"           => $msg,
        ]);
    }

    /**
     * Displays a single Empresa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    

        return $this->render('view', [
            'model'     => $model,
            'usumod'    => $usumod,
        ]);
    }

    /**
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Empresa();
        $model->nombre = trim(ucwords($model->nombre));
        $model->usumod = Yii::$app->user->identity->idusu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $modelpm = new Planmarketing();
            $modelpm->idemp  = $model->idemp;
            $modelpm->nombre = "Analisis Situacion Externa";
            $modelpm->orden  = 1;
            $modelpm->usumod = Yii::$app->user->identity->idusu;
            $modelpm->save();

            $modelpm = new Planmarketing();
            $modelpm->idemp  = $model->idemp;
            $modelpm->nombre = "Analisis Situacion Interna";
            $modelpm->orden  = 2;
            $modelpm->usumod = Yii::$app->user->identity->idusu;
            $modelpm->save();

            $modelpm = new Planmarketing();
            $modelpm->idemp  = $model->idemp;
            $modelpm->nombre = "Diagnostico de la Situacion";
            $modelpm->orden  = 3;
            $modelpm->usumod = Yii::$app->user->identity->idusu;
            $modelpm->save();

              $modelpmc = new Pmcontenido();
              $modelpmc->idpm  = $modelpm->idpm;
              $modelpmc->titulo = "Fortaleza";
              $modelpmc->orden  = 1;
              $modelpmc->usumod = Yii::$app->user->identity->idusu;
              $modelpmc->save();

              $modelpmc = new Pmcontenido();
              $modelpmc->idpm  = $modelpm->idpm;
              $modelpmc->titulo = "Oportunidades";
              $modelpmc->orden  = 2;
              $modelpmc->usumod = Yii::$app->user->identity->idusu;
              $modelpmc->save();

              $modelpmc = new Pmcontenido();
              $modelpmc->idpm  = $modelpm->idpm;
              $modelpmc->titulo = "Debilidades";
              $modelpmc->orden  = 3;
              $modelpmc->usumod = Yii::$app->user->identity->idusu;
              $modelpmc->save();

              $modelpmc = new Pmcontenido();
              $modelpmc->idpm  = $modelpm->idpm;
              $modelpmc->titulo = "Amenazas";
              $modelpmc->orden  = 4;
              $modelpmc->usumod = Yii::$app->user->identity->idusu;
              $modelpmc->save();



            $modelpm = new Planmarketing();
            $modelpm->idemp  = $model->idemp;
            $modelpm->nombre = "Desiciones Extrategicas";
            $modelpm->orden  = 4;
            $modelpm->usumod = Yii::$app->user->identity->idusu;
            $modelpm->save();



            return $this->redirect(['view', 'id' => $model->idemp]);
        
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Empresa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idemp]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Empresa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        //$this->findModel($id)->delete();
      //  return $this->redirect(['index']);
        $msg  = "Exito!!!";  
        if(Yii::$app->request->post())
        {
            $idemp  = Html::encode($_POST["idemp"]);
            $cte    = Empresainf::find()->where(['idemp' => $idemp])->count();
            $ctu    = Usuario::find()->where(['idemp' => $idemp])->count();
            $ctpm   = Planmarketing::find()->where(['idemp' => $idemp])->count();

            $form = new EmpresaSearchForm;

            if((int) $idemp && $cte == 0 && $ctu == 0 && $ctpm ==0)
            {
                if(Empresa::deleteAll("idemp=:idemp", [":idemp" => $idemp]))
                {
                    $msg = "Empresa con id $idemp eliminada con éxito.";
                  ///  echo "<meta http-equiv='refresh' content='1; ".Url::toRoute("empresa/index")."'>";
                   return $this->redirect(["empresa/index", 'msg' => $msg]);
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar la Empresa redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("empresa/index")."'>"; 
                }
            }
            else
            {
                //echo "La empresa tiene informacion realacionada, no se puede eliminar, redireccionando ...";
             //   echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("empresa/index")."'>";
                $msg = "La empresa tiene informacion realacionada, no se puede eliminar";
                return $this->redirect(["empresa/index", 'msg' => $msg]);
            }
        }
        else
        {
           return $this->redirect(["empresa/index", 'msg' => $msg]);
        }
    }

    /**
     * Finds the Empresa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
