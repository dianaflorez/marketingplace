<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use app\models\EmpresaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\EmpresaSearchForm;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Empresa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpresaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $table = new Empresa;
        $model = $table->find()->andWhere('idemp > 1')->all();

        $form = new EmpresaSearchForm;
        $search = null;
        if($form->load(Yii::$app->request->get()))
        {
             if ($form->validate())
            {
                $search = Html::encode($form->q);
                $table = Empresa::find()
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
                $table = Empresa::find();
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
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            "form" => $form, 
            "search" => $search,
            "pages" => $pages
        ]);
    }

    /**
     * Displays a single Empresa model.
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
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Empresa();

        $model->usumod = Yii::$app->user->identity->idusu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

        if(Yii::$app->request->post())
        {
            $idemp = Html::encode($_POST["idemp"]);
            if((int) $idemp)
            {
                if(Empresa::deleteAll("idemp=:idemp", [":idemp" => $idemp]))
                {
                    echo "Empresa con id $idemp eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("empresa/index")."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar la Empresa redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("empresa/index")."'>"; 
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar la empresa, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("empres/index")."'>";
            }
        }
        else
        {
            return $this->redirect(["empresa/index"]);
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
