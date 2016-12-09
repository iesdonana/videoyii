<?php

namespace app\models;

class DevolverForm extends \yii\base\Model
{
    public $numero;

    public function rules()
    {
        return [
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
            'numero' => 'Número',
        ];
    }
}
