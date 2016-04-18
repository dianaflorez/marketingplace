<?php

namespace app\controllers;

use Yii;
use app\models\Producto;
use app\models\Empresa;
use app\models\Usuario;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends Controller
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
     * Lists all Producto models.
     * @return mixed
     */
    public function actionIndex($id, $msg =null)
    {
        $model = Producto::find()->where(['idemp' => $id])->all();

        $emp    = Empresa::findOne(['idemp' => $id]);

        return $this->render('index', [
            'model'   => $model,   
            'msg'     => $msg,
            'idemp'   => $id,
            'emp'     => $emp, 
        
        ]);
    }

    /**
     * Displays a single Producto model.
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
     * Creates a new Producto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Producto();
        $model->idemp   = $id;
        $model->usumod  = Yii::$app->user->identity->idusu;

        $emp    = Empresa::findOne(['idemp' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpro]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'emp'   => $emp,
            ]);
        }
    }

    /**
     * Updates an existing Producto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;

        $emp    = Empresa::findOne(['idemp' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpro]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'emp'   => $emp,
            ]);
        }
    }

    /**
     * Deletes an existing Producto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->fecmod  = date('Y.m.d h:i:s');
        $model->usumod  = Yii::$app->user->identity->idusu;
        $model->estado  = "Inactivo";

        $emp    = Empresa::findOne(['idemp' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpro]);
        } 
            return $this->redirect(['view', 'id' => $model->idpro]);

    }

    /**
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
