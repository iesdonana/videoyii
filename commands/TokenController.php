<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Usuario;
use yii\console\Controller;

/**
 * Acciones relacionadas con el token de un usuario.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TokenController extends Controller
{
    /**
     * Este comando regenera los tokens de todos los usuarios o sólo del usuario
     * indicado
     * @param int $id El ID del usuario al que se desea cambiar el token
     */
    public function actionIndex($id = null)
    {
        if ($id !== null) {
            $usuario = Usuario::findOne($id);
            $usuario->token = \Yii::$app->security->generateRandomString();
            $usuario->save(false);
        } else {
            foreach (Usuario::find()->all() as $usuario) {
                $usuario->token = \Yii::$app->security->generateRandomString();
                $usuario->save(false);
            }
        }
    }
}
