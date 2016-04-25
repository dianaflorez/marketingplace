<?php

namespace app\controllers;

use Yii;
use app\models\Dirtel;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\models\User;

/**
 * DirtelController implements the CRUD actions for Dirtel model.
 */
class DirtelController extends Controller
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
     * Lists all Dirtel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Dirtel::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dirtel model.
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
     * Creates a new Dirtel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp, $tabla, $idtabla, $idtipo,$cliente)
    {
        $model = new Dirtel();
        $model->idemp   = $idemp;
        $model->tabla   = $tabla;
        $model->idtabla = $idtabla;
        $model->idtipo    = $idtipo; //tipo cliente 
        $model->id_pais = '170';
        $model->id_dep  = '52';
        $model->id_mun  = '001';
        $model->usumod  = Yii::$app->user->identity->idusu;

        //lbl Label para el ingreso de la informacion
        if($idtipo == 11) $lbl = "Direccion ppal.";
        if($idtipo == 12) $lbl = "Direccion Oficina";
        if($idtipo == 13) $lbl = "Telefono Fijo";
        if($idtipo == 14) $lbl = "Celular";

        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $model->idemp = Yii::$app->user->identity->idemp;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['cliente/index', 
                                    'idemp' => $model->idemp, 
                                    'cliente' => $cliente]);
        } else {
             // print_r($model->getErrors());

            return $this->render('create', [
                'model' => $model,
                'emp'   => $emp,
                'cliente' => $cliente,
                'lbl'   => $lbl,
            ]);
        }
    }

    /**
     * Updates an existing Dirtel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $lbl,$cliente)
    {
        $model = $this->findModel($id);
        
        $emp = Empresa::findOne(['idemp' => $model->idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->redirect(['cliente/index', 
                                    'idemp' => $model->idemp, 
                                    'cliente' => $cliente]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'lbl'   => $lbl,
                'emp'   => $emp,
                'cliente'=> $cliente,
            ]);
        }
    }

    /**
     * Deletes an existing Dirtel model.
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
            $iddirtel  = Html::encode($_POST["iddirtel"]);

            if((int) $idemp)
            {
                if(Dirtel::deleteAll("iddirtel=:iddirtel", [":iddirtel" => $iddirtel]))
                {
                    $msg = "Direccion con id $iddirtel eliminada con éxito.";
                  ///  echo "<meta http-equiv='refresh' content='1; ".Url::toRoute("empresa/index")."'>";
                   return $this->redirect(["cliente/index",'idemp' => $idemp, 'msg' => $msg]);
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar la Empresa redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("cliente/index")."'>"; 
                }
            }
            else
            {
                //echo "La empresa tiene informacion realacionada, no se puede eliminar, redireccionando ...";
             //   echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("empresa/index")."'>";
                $msg = "La empresa tiene informacion realacionada, no se puede eliminar";
                   return $this->redirect(["cliente/index",'id' => $idemp, 'msg' => $msg]);
            }
        }
        else
        {
           return $this->redirect(["cliente/index",'id' => $idemp, 'msg' => $msg]);
        }
    }

    /**
     * Finds the Dirtel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dirtel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dirtel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
