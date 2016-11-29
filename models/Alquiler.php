<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alquileres".
 *
 * @property integer $id
 * @property integer $socio_id
 * @property integer $pelicula_id
 * @property string $precio_alq
 * @property string $alquilado
 * @property string $devuelto
 *
 * @property Peliculas $pelicula
 * @property Socios $socio
 */
class Alquiler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alquileres';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['socio_id', 'pelicula_id', 'precio_alq'], 'required'],
            [['socio_id', 'pelicula_id'], 'integer'],
            [['precio_alq'], 'number'],
            [['alquilado', 'devuelto'], 'safe'],
            [['pelicula_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pelicula::className(), 'targetAttribute' => ['pelicula_id' => 'id']],
            [['socio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Socio::className(), 'targetAttribute' => ['socio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'socio_id' => 'Socio ID',
            'pelicula_id' => 'Pelicula ID',
            'precio_alq' => 'Precio Alq',
            'alquilado' => 'Alquilado',
            'devuelto' => 'Devuelto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelicula()
    {
        return $this->hasOne(Peliculas::className(), ['id' => 'pelicula_id'])->inverseOf('alquilers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocio()
    {
        return $this->hasOne(Socios::className(), ['id' => 'socio_id'])->inverseOf('alquilers');
    }
}
