<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */

$url_numero = Url::to(['alquileres/numero-ajax']);
$url_codigo = Url::to(['alquileres/codigo-ajax']);
$js = <<<JS
    $('.field-alquilerform-numero .hint-block').html(' ');
    $('.field-alquilerform-codigo .hint-block').html(' ');
    $('#alquilerform-numero').change(function() {
        var v = $('#alquilerform-numero').val();
        $.ajax({
            url: "$url_numero",
            method: "POST",
            data: { numero : v },
            success: function(nombre) {
                $('.field-alquilerform-numero .hint-block').html(nombre);
            }
        });
    });
    $('#alquilerform-codigo').change(function() {
        var v = $('#alquilerform-codigo').val();
        $.ajax({
            url: "$url_codigo",
            method: "POST",
            data: { codigo : v },
            success: function(titulo) {
                $('.field-alquilerform-codigo .hint-block').html(titulo);
            }
        });
    });
JS;
$this->registerJs($js);
?>

<div class="alquileres-alquilar">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'numero')->hint(' '); ?>
        <?= $form->field($model, 'codigo')->hint(' '); ?>

        <div class="form-group">
            <?= Html::submitButton('Alquilar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- alquileres-alquilar -->
