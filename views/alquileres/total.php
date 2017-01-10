<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */
?>
<div class="alquileres-total">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['total'],
    ]); ?>
        <?= $form->field($model, 'fecha')->dropDownList($fechas) ?>
        <div class="form-group">
            <?= Html::submitButton('Calcular total', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <?php
    if ($total !== null) {
        ?>
        <h3>El total es <?= Html::encode(Yii::$app->formatter->asCurrency($total)) ?></h3>
    <?php

    }
    ?>
</div><!-- alquileres-total -->
