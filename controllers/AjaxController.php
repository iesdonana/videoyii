<?php

namespace app\controllers;

class AjaxController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAjax()
    {
        return json_encode('hola');
    }
}
