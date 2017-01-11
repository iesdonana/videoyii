<?php

namespace app\models;

use Yii;

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
    public $passwordConfirm;

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
            [['nombre', 'password', 'passwordConfirm'], 'required'],
            [['nombre'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 60],
            [['nombre'], 'unique'],
            [['passwordConfirm'], 'confirmarPassword'],
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
            'password' => 'Contraseña',
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
        if ($this->password !== $this->passwordConfirm) {
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->token = Yii::$app->security->generateRandomString();
            return true;
        } else {
            return false;
        }
    }
}
