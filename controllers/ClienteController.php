<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use app\models\Tipo;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
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
     * Lists all Cliente models.
     * @return mixed
     */
    public function actionIndex($idemp, $msg=null, $cliente='Institucional')
    {
        $model = Cliente::find()
          //      ->joinWith(['accions'])
                ->where(['cliente.idemp' => $idemp, 'tipo' => $cliente])
          //      ->joinWith(['elementos'])
           //     ->where(['elemento.idemp' => $id])
                ->all();
         
        $emp    = Empresa::findOne(['idemp' => $idemp]);

          return $this->render('index', [
            'model'     => $model,
            'cliente'   => $cliente,
            'msg'       => $msg,
            'emp'       => $emp,
        ]);
    }

    /**
     * Displays a single Cliente model.
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
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp, $cliente )
    {
        $model = new Cliente();
        $model->idemp   = $idemp;
        $model->tipo    = $cliente; //tipo cliente 
        $model->usumod  = Yii::$app->user->identity->idusu;

        $msg = "";

        $tide = ArrayHelper::map(Tipo::find(['table' => 'usuario'])->all(), 'idtipo', 'nombre');
        $genero = ['Femenino'=>'Femenino', 'Masculino'=>'Masculino'];  
        $estado = ['Activo'=>'Activo', 'Inactivo'=>'Inactivo'];  

        $emp = Empresa::findOne(['idemp' => $idemp]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          
            return $this->redirect(['index', 'idemp' => $model->idemp]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'tide'  => $tide, 
                'msg'   => $msg,
                'genero'=> $genero,
                'tipo'  => $cliente,
                'estado'=> $estado,
                'emp'   => $emp,
                'cliente' => $cliente,
            ]);
        }
    }

    /**
     * Updates an existing Cliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;
        $msg = "";

        $tipocli = $model->tipo;

        $tide = ArrayHelper::map(Tipo::find(['table' => 'usuario'])->all(), 'idtipo', 'nombre');
        $genero = ['Femenino'=>'Femenino', 'Masculino'=>'Masculino'];  
        $estado = ['Activo'=>'Activo', 'Inactivo'=>'Inactivo'];  

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcli]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tide'  => $tide, 
                'msg'   => $msg,
                'genero'=> $genero,
                'tipo'  => $tipocli,
                'estado'=> $estado,
                'cliente'=> $tipocli,
            ]);
        }
    }

    /**
     * Deletes an existing Cliente model.
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
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
