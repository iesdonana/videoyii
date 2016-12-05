<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */

$urlNumero = Url::to(['alquileres/numero-ajax']);
$urlCodigo = Url::to(['alquileres/codigo-ajax']);
$js = <<<JS
    $('.field-alquilerform-numero .hint-block').html(' ');
    $('.field-alquilerform-codigo .hint-block').html(' ');
    var handlerNumero = function() {
        var v = $('#alquilerform-numero').val();
        $.ajax({
            url: "$urlNumero",
            method: "POST",
            data: { numero: v },
            success: function(nombre) {
                $('.field-alquilerform-numero .hint-block').html(nombre);
            }
        });
    };
    $('#alquilerform-numero').change(handlerNumero);
    $('#alquilerform-numero').on('keyup', handlerNumero);
    var handlerCodigo = function() {
        var v = $('#alquilerform-codigo').val();
        $.ajax({
            url: "$urlCodigo",
            method: "POST",
            data: { codigo: v },
            success: function(titulo) {
                $('.field-alquilerform-codigo .hint-block').html(titulo);
            }
        });
    };
    $('#alquilerform-codigo').change(handlerCodigo);
    $('#alquilerform-codigo').on('keyup', handlerCodigo);
JS;
$this->registerJs($js);
?>
<div class="alquileres-alquilar">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'numero')->hint(' ') ?>
        <?= $form->field($model, 'codigo')->hint(' ') ?>
        <div class="form-group">
            <?= Html::submitButton('Alquilar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- alquileres-alquilar -->
