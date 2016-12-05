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

class AlquileresController extends \yii\web\Controller
{
    public function actionAlquilar()
    {
        $model = new AlquilerForm;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $alquiler = new Alquiler;
                if ($alquiler->alquilar($model->numero, $model->codigo)) {
                    return $this->redirect(Url::to(['alquileres/index']));
                }
            }
        }

        $socios = Socio::find()
            ->select(new Expression("numero || ' ' || nombre as nombre, numero"))
            ->indexBy('numero')
            ->column();
        $peliculas = Pelicula::find()
            ->select(new Expression("codigo || ' ' || titulo as titulo, codigo"))
            ->indexBy('codigo')
            ->column();

        return $this->render('alquilar', [
            'model' => $model,
            'socios' => $socios,
            'peliculas' => $peliculas,
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
