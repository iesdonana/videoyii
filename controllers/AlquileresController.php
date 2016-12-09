<?php

namespace app\controllers;

use Yii;
use app\models\AlquilerForm;
use app\models\DevolverForm;
use app\models\Alquiler;
use app\models\AlquilerSearch;
use app\models\Socio;
use app\models\Pelicula;
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

    public function actionDelete($id)
    {
        $alquiler = Alquiler::findOne($id);
        if ($alquiler !== null) {
            $alquiler->devuelto = new \yii\db\Expression('current_timestamp');
            $alquiler->save();
            $this->redirect(Url::to(['alquileres/devolver']));
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
