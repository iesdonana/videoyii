<?php

namespace app\controllers;

use Yii;
use app\models\Pelicula;
use app\models\PeliculaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PeliculasController implements the CRUD actions for Pelicula model.
 */
class PeliculasController extends Controller
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
     * Lists all Pelicula models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeliculaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'alquilada' => $this->$model->getEstaAlquilada(),
        ]);
    }

    /**
     * [actionView description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionView($id)
    {
        $model = new Pelicula();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pelicula model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pelicula();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * [actionUpdate description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * [actionDelete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
/**
 * [findModel description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
    protected function findModel($id)
    {
        if (($model = Pelicula::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
