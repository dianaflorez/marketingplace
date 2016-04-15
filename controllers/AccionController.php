<?php

namespace app\controllers;

use Yii;
use app\models\Accion;
use app\models\Usuario;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * AccionController implements the CRUD actions for Accion model.
 */
class AccionController extends Controller
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

    /**
     * Lists all Accion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Accion::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Accion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    
        $nomemp = Empresa::findOne(['idemp' => $model->idemp]);  
        $nomemp = strtoupper($nomemp->nombre);
       
        return $this->render('view', [
            'model'     => $model,
            'usumod'    => $usumod,
            'nomemp'    => $nomemp,

        ]);
    }

    /**
     * Creates a new Accion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idpa, $idemp)
    {
        $model = new Accion();
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
     * Updates an existing Accion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idaccion]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'emp'   => $emp,
            ]);
        }
    }

    /**
     * Deletes an existing Accion model.
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
            $idaccion  = Html::encode($_POST["idaccion"]);

            if((int) $idemp)
            {
                if(Accion::deleteAll("idaccion=:idaccion", [":idaccion" => $idaccion]))
                {
                    $msg = "Accion con id $idaccion eliminada con éxito.";
                  ///  echo "<meta http-equiv='refresh' content='1; ".Url::toRoute("empresa/index")."'>";
                   return $this->redirect(["planaccion/index",'id' => $idemp, 'msg' => $msg]);
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
                   return $this->redirect(["planaccion/index",'id' => $idemp, 'msg' => $msg]);
            }
        }
        else
        {
           return $this->redirect(["planaccion/index",'id' => $idemp, 'msg' => $msg]);
        }
    }

    /**
     * Finds the Accion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
