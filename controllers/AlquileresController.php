<?php

namespace app\controllers;

use Yii;
use app\models\Alquiler;
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
                    Yii::$app->session->setFlash('fracaso', 'La película ya esta alquilada.');
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

    public function actionDevolver()
    {
        return $this->render('devolver');
    }
}
