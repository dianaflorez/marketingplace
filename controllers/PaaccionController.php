<?php

namespace app\controllers;

use Yii;
use app\models\Paaccion;
use app\models\Empresa;
use app\models\Usuario;
use app\models\Planaccion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * PaaccionController implements the CRUD actions for Paaccion model.
 */
class PaaccionController extends Controller
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
     * Lists all Paaccion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Paaccion::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paaccion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);
        $usumod = Usuario::findOne(['idusu' => $model->usumod]);
        $usumod = ucwords($usumod->nombre1.' '.$usumod->apellido1);    
        $emp = Empresa::findOne(['idemp' => $model->idemp]);  
        
        return $this->render('view', [
            'model'     => $model,
            'usumod'    => $usumod,
            'emp'       => $emp,

        ]);
    }

    /**
     * Creates a new Paaccion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idpa, $idemp,$pa)
    {
        $model = new Paaccion();
        $model->idemp   = $idemp;
        $model->idpa    = $idpa;
        $model->usumod  = Yii::$app->user->identity->idusu;

        //Si un usuario q no es adm Solo puede crear de su propia emp 
       if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $model->idemp = Yii::$app->user->identity->idemp;

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
        $estado = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado', 
                    'Pendiente'=>'Pendiente', 'Terminado'=>'Terminado'];  

        $fecha = date('Y.m.d');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['planaccion/index', 'id' => $model->idemp, 'pa'=>$pa]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'emp'   => $emp,
                'estado'=> $estado, 
                'fecha' => $fecha,     
                'pa'    => $pa,
            ]);
        }
    }

    /**
     * Updates an existing Paaccion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        $estado = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado', 
                    'Pendiente'=>'Pendiente', 'Terminado'=>'Terminado'];  

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idaccion]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'estado'  => $estado, 
                'emp'   => $emp,
             ]);
        }
    }

    /**
     * Deletes an existing Paaccion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

        $id  = Html::encode($_POST["idaccion"]);

        $model = $this->findModel($id);
        $model->estado = "Anulado";
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        $estado = ['En Ejecucion'=>'En Ejecucion','Ejecutado'=>'Ejecutado', 
                    'Pendiente'=>'Pendiente', 'Terminado'=>'Terminado'];  

        $emp = Empresa::findOne(['idemp' => $model->idemp]);
       
        $model->save();
        return $this->redirect(['planaccion/index', 'id' => $model->idemp]);
    }

    /**
     * Finds the Paaccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paaccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paaccion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
