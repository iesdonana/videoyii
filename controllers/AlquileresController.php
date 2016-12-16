<?php

namespace app\controllers;

use Yii;
use app\models\Pelicula;
use app\models\PeliculaForm;
use app\models\AlquilerForm;
use app\models\DevolverForm;
use app\models\Alquiler;
use app\models\GestionarForm;
use app\models\AlquilerSearch;
use app\models\Socio;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AlquileresController extends \yii\web\Controller
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
    public function actionGestionar($numero = null)
    {
        $model = new GestionarForm;
        $model2 = new PeliculaForm;
        $alquileres = [];
        if ($numero !== null) {
            $model->numero = $numero;
            if ($model->validate()) {
                $model->esValido = true;
                if ($model2->load(Yii::$app->request->post()) && $model2->validate()) {
                    (new Alquiler)->alquilar($model->numero, $model2->codigo);
                    $model2->codigo = '';
                }
                $alquileres = Socio::findOne(['numero' => $model->numero])->pendientes;
            }
        }
        return $this->render('gestionar', [
            'model' => $model,
            'model2' => $model2,
            'alquileres' => $alquileres,
        ]);
    }

    public function actionTotal($get)
    {
        $query = (new \yii\db\Query())->from('alquiler')->where(['dia' => $get]);
        $suma = $query->sum('precio_alq');
        return $suma;
    }

    public function actionDevolver()
    {
        $model = new DevolverForm();
        $dataProvider = null;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $socio = Socio::find()->where(['numero' => $model->numero])->one();
                $alquileres = $socio->getAlquileres()->where(['devuelto' => null])->orderBy('alquilado desc');
                $dataProvider = new ActiveDataProvider([
                    'query' => $alquileres,
                    'sort' => false,
                ]);
            }
        }
        return $this->render('devolver', [
             'model' => $model,
             'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDelete($id, $numero = null)
    {
        $alquiler = Alquiler::findOne($id);
        if ($alquiler !== null) {
            $alquiler->devuelto = new \yii\db\Expression('current_timestamp');
            $alquiler->save();
            Yii::$app->session->setFlash('exito', 'Película devuelta correctamente.');
            $url = ['alquileres/gestionar'];
            if ($numero !== null) {
                $url['numero'] = $numero;
            }
            $this->redirect($url);
        } else {
            throw new NotFoundHttpException('Socio no encontrado.');
        }
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
