<?php

namespace app\controllers;

use Yii;
use app\models\AlquilerForm;
use app\models\Alquiler;
use app\models\AlquilerSearch;
use app\models\Socio;
use app\models\Pelicula;
use yii\helpers\Url;

class AlquileresController extends \yii\web\Controller
{
    public function actionAlquilar()
    {
        $model = new AlquilerForm;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $alquiler = new Alquiler;
                if ($alquiler->alquilar($model->numero, $model->codigo)) {
                    return $this->redirect(Url::to(['alquileres/alquilar']));
                }
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

    public function actionNumeroAjax()
    {
        $numero = Yii::$app->request->post('numero');
        if (is_numeric($numero)) {
            $socio = Socio::find()->where(['numero' => $numero])->one();
            if ($socio !== null) {
                return $socio->nombre;
            }
        }
        return 'No existe ese socio';
    }

    public function actionCodigoAjax()
    {
        $codigo = Yii::$app->request->post('codigo');
        if (is_numeric($codigo)) {
            $pelicula = Pelicula::find()->where(['codigo' => $codigo])->one();
            if ($pelicula !== null) {
                return $pelicula->titulo;
            }
        }

        return 'No existe esa pelicula';
    }
}
