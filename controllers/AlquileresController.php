<?php

namespace app\controllers;

use Yii;
use app\models\Alquiler;
use app\models\AlquilerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AlquilerForm;
use app\models\Socio;
use app\models\Pelicula;
use yii\helpers\Url;

class AlquileresController extends \yii\web\Controller
{
    public function actionAlquilar()
    {
        $model = new AlquilerForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                $socio_id = Socio::find()
                    ->select('id')
                    ->where(['numero' => $model->numero])
                    ->scalar();
                $pelicula = Pelicula::find()
                    ->select('id, precio')
                    ->where(['codigo' => $model->codigo])
                    ->one();
                $pelicula_id = $pelicula->id;
                $precio_alq = $pelicula->precio;
                $alquiler = new Alquiler([
                    'socio_id' => $socio_id,
                    'pelcula_id' => $pelicula_id,
                    'precio_alq' => $precio_alq,
                ]);
                if ($pelicula->estaAlquilada) {
                    Yii::$app->session->setFlash('fracaso', 'La película ya está alquilada.');
                } else {
                    $alquiler->save();
                    Yii::$app->session->setFlash('exito', 'Alquiler realizado correctamente.');
                    return $this->redirect(Url::to(['alquileres/alquilar']));
                }
            }
        }

        return $this->render('alquilar', [
        'model' => $model,
        ]);
    }

    /**
     * Lists all Alquiler models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlquilerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Alquiler model.
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
     * Creates a new Alquiler model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Alquiler();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Alquiler model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing Alquiler model.
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
     * Finds the Alquiler model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Alquiler the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alquiler::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
