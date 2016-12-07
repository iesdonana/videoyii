<?php

namespace app\models;

use app\models\Pelicula;

class AlquilerForm extends \yii\base\Model
{
    public $numero;
    public $codigo;

    public function rules()
    {
        return [
            [['numero', 'codigo'], 'required'],
            [['numero', 'codigo'], 'number'],
            [['numero'], 'exist',
                'skipOnError' => true,
                'targetClass' => Socio::className(),
                'targetAttribute' => ['numero' => 'numero'],
            ],
            [['codigo'], 'exist',
                'skipOnError' => true,
                'targetClass' => Pelicula::className(),
                'targetAttribute' => ['codigo' => 'codigo'],
            ],
            [['codigo'], function ($attribute, $params) {
                $pelicula = Pelicula::find()
                    ->where(['codigo' => $this->$attribute])
                    ->one();
                if ($pelicula === null || $pelicula->estaAlquilada) {
                    $this->addError($attribute, 'La película ya está alquilada.');
                }
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'numero' => 'Número de socio',
            'codigo' => 'Código de película',
        ];
    }
}
