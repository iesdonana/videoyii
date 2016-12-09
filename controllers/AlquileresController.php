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
use yii\db\Expression;
use yii\web\Response;
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
        $model = new DevolverForm();
        $alquileres = null;
        /*$dataProvider = null;*/

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $socio = Socio::find()->where(['numero' => $model->numero])->one();
                $alquileres = $socio->getAlquileres()->where(['devuelto' => null])->orderBy('alquilado desc')->all();
                /*$socio = Socio::find()->where(['numero' => $model->numero])->one();
                $alquileres = $socio->getAlquileres()->where(['devuelto' => null])->orderBy('alquilado desc');
                $dataProvider = new ActiveDataProvider([
                    'query' => $alquileres,
                    'sort' => false,
                ]);*/
            }
        }

        return $this->render('devolver', [
             'model' => $model,
             'alquileres' => $alquileres,
             /*'dataProvider' => $dataProvider,*/
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
                // Si la Expression contiene paréntesis, el WHERE no le pondrá comillas
                // https://github.com/yiisoft/yii2/blob/master/framework/db/QueryBuilder.php#L1340
                ->where(['ilike', new Expression("(numero || ' ' || nombre)"), $q])
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
