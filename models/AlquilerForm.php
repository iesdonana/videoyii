<?php

namespace app\models;

use yii\base\Model;

class AlquilerForm extends Model
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
                'targetAttribute' => ['numero' => 'numero']],
            [['codigo'], 'exist',
                'skipOnError' => true,
                'targetClass' => Pelicula::className(),
                'targetAttribute' => ['codigo' => 'codigo']],
        ];
    }

    public function attributeLables()
    {
        return [
            'numero' => 'Número de socio',
            'codigo' => 'Código de película',
        ];
    }
}
