<?php

namespace app\controllers;

use Yii;
use app\models\AlquilerForm;
use app\models\Alquiler;
use app\models\AlquilerSearch;
use app\models\Socio;
use app\models\Pelicula;
use yii\helpers\Url;
use yii\db\Expression;
use yii\web\Response;

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

        $nombre = empty($model->numero) ? '' :
                      Socio::find()
                      ->select('nombre')
                      ->where(['numero' => $model->numero])
                      ->scalar();

        return $this->render('alquilar', [
            'model' => $model,
            'nombre' => $nombre,
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

    public function actionListaSocios($q = null, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [
            'results' => [
                'id' => '',
                'text' => '',
            ],
        ];
        if (!is_null($q)) {
            $out['results'] = Socio::find()
                ->select(new Expression("numero as id, numero || ' ' || nombre as text"))
                ->where(['ilike', 'nombre', $q])
                ->limit(20)
                ->asArray()
                ->all();
        } elseif (!is_null($numero)) {
            $out['results'] = [
                'id' => $numero,
                'text' => Socio::find()
                    ->select(new Expression("numero || ' ' || nombre"))
                    ->where(['numero' => $id])
                    ->scalar(),
            ];
        }
        return $out;
    }
}
