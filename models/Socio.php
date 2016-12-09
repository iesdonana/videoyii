<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "socios".
 *
 * @property integer $id
 * @property string $numero
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property boolean $borrado
 *
 * @property Alquileres[] $alquileres
 */
class Socio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'socios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero', 'nombre'], 'required'],
            [['numero', 'telefono'], 'number'],
            [['borrado'], 'boolean'],
            [['nombre', 'direccion'], 'string', 'max' => 255],
            [['numero'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero' => 'Numero',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'borrado' => 'Borrado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlquileres()
    {
        return $this->hasMany(Alquiler::className(), ['socio_id' => 'id'])->inverseOf('socio');
    }

    public function getPeliculas()
    {
        return $this->hasMany(Pelicula::className(), ['id' => 'pelicula_id'])->via('alquileres');
    }
}
