<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peliculas".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $titulo
 * @property string $precio
 * @property string $portada
 * @property boolean $borrado
 *
 * @property Alquileres[] $alquileres
 */
class Pelicula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'peliculas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'titulo', 'precio', 'portada'], 'required'],
            [['codigo', 'precio'], 'number'],
            [['borrado'], 'boolean'],
            [['codigo'], 'string', 'max' => 4],
            [['titulo'], 'string', 'max' => 255],
            [['portada'], 'string', 'max' => 255],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'titulo' => 'Titulo',
            'precio' => 'Precio',
            'borrado' => 'Borrado',
            'portada' => 'Portada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlquileres()
    {
        return $this->hasMany(Alquiler::className(), ['pelicula_id' => 'id'])->inverseOf('pelicula');
    }

    public function getSocios()
    {
        return $this->hasMany(Socio::className(), ['id' => 'socio_id'])
                    ->via('alquileres');
    }
}
