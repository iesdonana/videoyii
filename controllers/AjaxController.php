<?php

namespace app\controllers;

use yii\filters\VerbFilter;

class AjaxController extends \yii\web\Controller
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
                    'ajax' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAjax()
    {
        $info = [
            '1' => [1 => 'Jerez', 'Sanlúcar', 'El Puerto'],
            '2' => [1 => 'Camas', 'Lebrija', 'Las Cabezas'],
            '3' => [1 => 'Lepe', 'Almonte', 'Cortegana'],
        ];
        $id = \Yii::$app->request->post('id');
        return json_encode($info[$id]);
    }
}
