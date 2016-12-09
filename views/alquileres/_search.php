<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alquiler-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'socio_id') ?>

    <?= $form->field($model, 'pelicula_id') ?>

    <?= $form->field($model, 'precio_alq') ?>

    <?= $form->field($model, 'alquilado') ?>

    <?php // echo $form->field($model, 'devuelto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
