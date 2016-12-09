<?php

namespace app\controllers;

use Yii;
use app\models\AlquilerForm;
use app\models\Alquiler;
use app\models\Socio;
use app\models\Pelicula;
use app\models\AlquilerSearch;

class AlquileresController extends \yii\web\Controller
{
    public function actionAlquilar()
    {
        $model = new AlquilerForm;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                $alquiler = new Alquiler;
                $alquiler->alquilar($model->numero, $model->codigo);
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
        }

        return $this->render('alquilar', [
            'model' => $model,
        ]);
    }

    public function actionDevolver()
    {
        return $this->render('devolver');
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
}
