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
 * Acciones relacionadas con el mantenimiento del sistema.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LimpiarController extends Controller
{
    /**
     * Limpia del sistema los usuarios que no se han activado en el plazo
     * necesario
     */
    public function actionIndex()
    {
        echo Usuario::deleteAll(['>', '(current_timestamp - created_at)', '48 hours']);
    }
}
