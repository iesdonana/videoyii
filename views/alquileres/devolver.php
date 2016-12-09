<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alquiler */
/* @var $form ActiveForm */
?>
<div class="alquileres-devolver">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'socio_id') ?>
        <?= $form->field($model, 'pelicula_id') ?>
        <?= $form->field($model, 'precio_alq') ?>
        <?= $form->field($model, 'alquilado') ?>
        <?= $form->field($model, 'devuelto') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- alquileres-devolver -->
