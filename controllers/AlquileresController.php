<?php

namespace app\controllers;

use Yii;
use app\helpers\Mensaje;
use app\models\Pelicula;
use app\models\TotalForm;
use app\models\PeliculaForm;
use app\models\AlquilerForm;
use app\models\DevolverForm;
use app\models\Alquiler;
use app\models\GestionarForm;
use app\models\AlquilerSearch;
use app\models\Socio;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\grid\GridView;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['alquilar', 'gestionar', 'devolver'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['alquilar', 'gestionar', 'devolver'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->esAdmin;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionSocios($q = null, $id = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'items' => [
                'id' => '',
                'text' => '',
            ],
            'total_count' => 0,
        ];

        $socios = Socio::find()
            ->select('numero as id, nombre as text')
            ->asArray()
            ->all();
        $out['results'] = array_values($socios);

        if (!is_null($q)) {
            $query = Socio::find()->where(['ilike', 'nombre', $q]);
            $countQuery = clone $query;
            $totalCount = $countQuery->count();
            $pages = new Pagination([
                'totalCount' => $totalCount,
                'pageSize' => 6,
            ]);
            $data = $query
                ->select("numero as id, ('[' || numero || '] ' || nombre) as text")
                ->orderBy('numero')
                ->limit($pages->limit)
                ->offset($pages->offset)
                ->asArray()
                ->all();
            $out['items'] = array_values($data);
            $out['total_count'] = $totalCount;
        } elseif ($id > 0) {
            $socio = Socio::findOne(['numero' => $id]);
            $out['items'] = [
                'id' => $id,
                'text' => "[{$socio->numero}] {$socio->nombre}",
            ];
            $out['total_count'] = 1;
        }
        return $out;
    }

    public function actionTotal($fecha = null)
    {
        $model = new TotalForm;
        $fechas = Alquiler::find()
            ->select('(alquilado)::date')
            ->orderBy('alquilado desc')
            ->distinct(true)
            ->indexBy(function ($fila) {
                return $fila['alquilado'];
            })
            ->column();
        $total = null;

        $fechas = array_map([Yii::$app->formatter, 'asDate'], $fechas);

        if ($fecha !== null) {
            $model->fecha = $fecha;
            if ($model->validate()) {
                $total = Alquiler::find()
                    ->where(['(alquilado)::date' => $fecha])
                    ->sum('precio_alq');
            }
        }

        return $this->render('total', [
            'model' => $model,
            'fechas' => $fechas,
            'total' => $total,
        ]);
    }

    public function actionAlquilar()
    {
        $model = new AlquilerForm;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $alquiler = new Alquiler;
                if ($alquiler->alquilar($model->numero, $model->codigo)) {
                    return $this->redirect(['alquileres/alquilar']);
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

    public function actionDevolver($numero = null)
    {
        $model = new DevolverForm();
        $dataProvider = null;

        if ($numero !== null) {
            $model->numero = $numero;
            if ($model->validate()) {
                $socio = Socio::find()->where(['numero' => $numero])->one();
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
            Mensaje::exito('Película devuelta correctamente.');
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
