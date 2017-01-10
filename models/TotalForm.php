<?php

namespace app\models;

class TotalForm extends \yii\base\Model
{
    public $fecha;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['fecha'], 'required'],
            [['fecha'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fecha' => 'Fecha',
        ];
    }
}
