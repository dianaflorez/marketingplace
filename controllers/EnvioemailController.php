<?php

namespace app\controllers;

use Yii;
use app\models\Envioemail;
use app\models\Cliente;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnvioemailController implements the CRUD actions for Envioemail model.
 */
class EnvioemailController extends Controller
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
     * Lists all Envioemail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Envioemail::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Envioemail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $idemp)
    {
         if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $idemp = Yii::$app->user->identity->idemp;
     
        $emp    = Empresa::findOne(['idemp' => $idemp]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'emp'   => $emp,
        ]);
    }

    /**
     * Creates a new Envioemail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $msg = null;
        //Si un usuario q no es adm Solo puede crear de su propia emp 
        if(Yii::$app->user->identity->role != 4 &&   
           Yii::$app->user->identity->role !=7)
              $id = Yii::$app->user->identity->idemp;
     
        $model = new Envioemail();
        $model->idemp      = $id;
        $model->idusu      = Yii::$app->user->identity->idusu;

        $emp    = Empresa::findOne(['idemp' => $id]);

        $data = Cliente::find()
                ->where(['idemp' => $id])
                ->select(["CONCAT(nombre1,' ',apellido1) as label", 
                          "CONCAT(nombre1,' ',apellido1) as value",
                          "email",
                          'idcli as id'])
                ->asArray()
                ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $subject = $model->asunto;
             $body = $model->contenido;
              
             //Enviamos el correo
             Yii::$app->mailer->compose()
             ->setTo($model->email)
             ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
             ->setSubject($subject)
             ->setHtmlBody($body)
             ->send();
            return $this->redirect(['view', 'id' => $model->idenv, 'idemp' => $emp->idemp]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'data'  => $data,
                'emp'   => $emp,
                'msg'   => $msg,
            ]);
        }
    }

    /**
     * Updates an existing Envioemail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idenv]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Envioemail model.
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
     * Finds the Envioemail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Envioemail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Envioemail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
