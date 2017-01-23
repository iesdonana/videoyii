<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * This is the model class for table "usuarios".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $password
 * @property string $token
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * Escenario para cuando se crea un usuario
     * @var string
     */
    const ESCENARIO_CREATE = 'create';

    /**
     * Campo de contraseña en el formulario de alta y modificación de usuarios
     * @var string
     */
    public $pass;
    /**
     * Campo de confirmación de contraseña en el formulario de alta y
     * modificación de usuarios
     * @var string
     */
    public $passConfirm;

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'email'], 'required'],
            [['pass', 'passConfirm'], 'required', 'on' => self::ESCENARIO_CREATE],
            [['pass'], 'safe'],
            [['nombre'], 'string', 'max' => 15],
            [['nombre'], 'unique'],
            [['passConfirm'], 'confirmarPassword'],
            [['email'], 'email'],
            [['imageFile'], 'file', 'extensions' => 'png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'pass' => 'Contraseña',
            'passConfirm' => 'Confirmar contraseña',
            'imageFile' => 'Imagen',
        ];
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * Busca un usuario por su nombre.
     *
     * @param string $nombre
     * @return static|null
     */
    public static function buscarPorNombre($nombre)
    {
        return static::findOne(['nombre' => $nombre]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->token;
    }

    public function regenerarToken()
    {
        $this->token = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->token === $authKey;
    }

    /**
     * Validar contraseña.
     *
     * @param string $password contraseña a validar
     * @return bool si la contraseña es válida para el usuario actual
     */
    public function validarPassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function confirmarPassword($attribute, $params)
    {
        if ($this->pass !== $this->passConfirm) {
            $this->addError($attribute, 'Las contraseñas no coinciden');
        }
    }

    /**
     * Comprueba si el usuario es administrador.
     * @return bool si el usuario es administrador
     */
    public function esAdmin()
    {
        return $this->nombre === 'admin';
    }

    public function getImageUrl()
    {
        $uploads = Yii::getAlias('@uploads');
        $ruta = "$uploads/{$this->id}.png";
        return file_exists($ruta) ? "/$ruta" : "/$uploads/default.png";
    }

    /**
     * Indica si un usuario está activado. Un usuario está activado
     * su columna `activacion` contiene un valor nulo.
     * @return bool Si el usuario está activado o no
     */
    public function getActivado()
    {
        return $this->activacion === null;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->pass != '' || $insert) {
                $this->password = Yii::$app->security->generatePasswordHash($this->pass);
            }
            if ($insert) {
                $this->regenerarToken();
            }
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
            if ($this->imageFile !== null && $this->validate()) {
                $nombre = Yii::getAlias('@uploads/')
                    . $this->id . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs($nombre);
                Image::thumbnail($nombre, 120, null)
                    ->save($nombre, ['quality' => 50]);
            }
            return true;
        } else {
            return false;
        }
    }
}
