<?php

namespace app\models;

class GestionarForm extends \yii\base\Model
{
    public $numero;
    public $esValido = false;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['numero'], 'required'],
            [['numero'], 'number'],
            [['numero'], 'exist',
                'skipOnError' => true,
                'targetClass' => Socio::className(),
                'targetAttribute' => ['numero' => 'numero'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'numero' => 'Número de socio',
        ];
    }
}
