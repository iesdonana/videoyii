<?php

namespace app\models;

class PeliculaForm extends \yii\base\Model
{
    public $codigo;

    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'number'],
            [['codigo'], 'exist',
                'skipOnError' => true,
                'targetClass' => Pelicula::className(),
                'targetAttribute' => ['codigo' => 'codigo'],
            ],
            ['codigo', function ($attribute, $params) {
                $pelicula = Pelicula::findOne(['codigo' => $this->$attribute]);
                if ($pelicula !== null && $pelicula->estaAlquilada) {
                    $this->addError($attribute, 'La película ya está alquilada.');
                }
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'codigo' => 'Código de película',
        ];
    }
}
