<?php

namespace app\controllers;

use Yii;
use app\models\Cita;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CitaController implements the CRUD actions for Cita model.
 */
class CitaController extends Controller
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
     * Lists all Cita models.
     * @return mixed
     */
    public function actionIndex($idemp, $msg=null)
    {
        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $idemp = Yii::$app->user->identity->idemp;
 
        $model  = Cita::find()->where(['idemp' => $idemp])->all();
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('index', [
            'model' => $model,
            'emp'   => $emp,
            'msg'   => $msg,
        ]);
    }

    /**
     * Displays a single Cita model.
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
     * Creates a new Cita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp)
    {
        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $idemp = Yii::$app->user->identity->idemp;
 
        $model = new Cita();
        $model->idemp = $idemp;
        $model->idusu  = Yii::$app->user->identity->idusu;

        $model->usumod  = Yii::$app->user->identity->idusu;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcita]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcita]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cita model.
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
     * Finds the Cita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
