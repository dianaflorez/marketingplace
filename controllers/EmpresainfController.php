<?php

namespace app\controllers;

use Yii;
use app\models\Empresainf;
use app\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Tipo;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * EmpresainfController implements the CRUD actions for Empresainf model.
 */
class EmpresainfController extends Controller
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
     * Lists all Empresainf models.
     * @return mixed
     */
    public function actionIndex($id)
    {

        if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $id = Yii::$app->user->identity->idemp;

        $modelemp = Empresa::findOne($id);
        $model    = Empresainf::find()->where(['idemp' => $id])->joinWith(['idtipo0'])->all();
      
        return $this->render('index', [
            'model'     => $model,
            'idemp'     => $id,
            'modelemp'  => $modelemp,
        ]);
    }

    /**
     * Displays a single Empresainf model.
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
     * Creates a new Empresainf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idemp)
    {
        $model = new Empresainf();
       
        $tipos          = Tipo::find()->where(['tabla' => 'empresainf'])->all();
        $tipo           = ArrayHelper::map($tipos, 'idtipo', 'nombre');
        $model->idemp   = $idemp;

        if(!Yii::$app->user->identity->role == 4 || !Yii::$app->user->identity->role ==7)
            $model->idemp = Yii::$app->user->identity->idemp;

        $modelemp   = Empresa::findOne($model->idemp);

        $model->usumod = Yii::$app->user->identity->idusu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->idemp]);
        } else {
            return $this->render('create', [
                'model'     => $model,
                'tipo'      => $tipo,
                'modelemp'  => $modelemp,
            ]);
        }
    }

    /**
     * Updates an existing Empresainf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $tipos          = Tipo::find()->where(['tabla' => 'empresainf'])->all();
        $tipo           = ArrayHelper::map($tipos, 'idtipo', 'nombre');

        $modelemp   = Empresa::findOne($model->idemp);
        
        $model->fecmod = date('Y.m.d h:i:s');
        $model->usumod = Yii::$app->user->identity->idusu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->idemp]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tipo'      => $tipo,
                'modelemp'  => $modelemp,
            ]);
        }
    }

    /**
     * Deletes an existing Empresainf model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        //$this->findModel($id)->delete();
      //  return $this->redirect(['index']);

        if(Yii::$app->request->post())
        {
            $idinf = Html::encode($_POST["idinf"]);
            $idemp = Html::encode($_POST["idemp"]);
            if((int) $idemp)
            {
                if(Empresainf::deleteAll("idinf=:idinf", [":idinf" => $idinf]))
                {
                    echo "La informacion de la empresa con id $idinf eliminada con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='1; ".
                    Url::toRoute(["empresainf/index", "id" => $idemp])."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar la Empresa redireccionando ...";
                    echo "<meta http-equiv='refresh' content='1; ".Url::toRoute(["empresainf/index", "id" => $idemp])."'>"; 
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar la empresa, redireccionando ...";
                echo "<meta http-equiv='refresh' content='2; ".Url::toRoute(["empresainf/index", "id" => $idemp])."'>";
            }
        }
        else
        {
            return $this->redirect(["empresainf/index"]);
        }
    }

    /**
     * Finds the Empresainf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresainf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresainf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
