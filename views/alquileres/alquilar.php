<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */
?>
<div class="alquileres-alquilar">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'numero') ?>
        <?= $form->field($model, 'codigo') ?>
        <div class="form-group">
            <?= Html::submitButton('Alquilar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- alquileres-alquilar -->
