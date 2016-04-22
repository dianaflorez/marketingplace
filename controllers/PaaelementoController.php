<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use app\models\Paaelemento;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * PaaelementoController implements the CRUD actions for Paaelemento model.
 */
class PaaelementoController extends Controller
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
     * Lists all Paaelemento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Paaelemento::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paaelemento model.
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
     * Creates a new Paaelemento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp, $idpa, $idaccion, $pa)
    {
        $model = new Paaelemento();
        $model->idemp   = $idemp;
        $model->idpa    = $idpa;
        $model->idaccion   = $idaccion;
        $model->usumod  = Yii::$app->user->identity->idusu;

        //Si un usuario q no es adm Solo puede crear de su propia emp 
       if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $model->idemp = Yii::$app->user->identity->idemp;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['planaccion/index', 'id' => $model->idemp, 'pa'=>$pa]);
        } else {
            return $this->render('create', [
                'model' => $model, 
                'emp'   => $emp,
                'pa'    => $pa,
            ]);
        }
    }

    /**
     * Updates an existing Paaelemento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$pa)
    {
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
     
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['planaccion/index', 'id' => $model->idemp, 'pa'=>$pa]);
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'emp'   => $emp,
                'pa'    => $pa,
            ]);
        }
    }

    /**
     * Deletes an existing Paaelemento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
       $msg  = "Exito!!!";  
        if(Yii::$app->request->post())
        {
            $idemp  = Html::encode($_POST["idemp"]);
            $idele  = Html::encode($_POST["idele"]);

            if((int) $idemp)
            {
                if(Paaelemento::deleteAll("idele=:idele", [":idele" => $idele]))
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
     * Finds the Paaelemento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paaelemento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paaelemento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}