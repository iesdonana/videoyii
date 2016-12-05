<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
// use yii\web\JsExpression;
use kartik\select2\Select2;
use app\models\Socio;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */

$url = Url::to(['alquileres/lista-socios']);
?>
<div class="alquileres-alquilar">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'numero')->widget(Select2::classname(), [
            'initValueText' => $nombre, // set the initial display text
            'language' => 'es',
            'options' => [
                'placeholder' => 'Buscar un socio...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'ajax' => [
                    'url' => $url,
                    'delay' => 250,
                    'dataType' => 'json',
                    // 'data' => new JsExpression('function(params) { return { q: params.term }; }')
                ],
                // 'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                // 'templateResult' => new JsExpression('function(socio) { return socio.text; }'),
                // 'templateSelection' => new JsExpression('function (socio) { return socio.text; }'),
            ],
        ]); ?>
        <?= $form->field($model, 'codigo') ?>
        <div class="form-group">
            <?= Html::submitButton('Alquilar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- alquileres-alquilar -->
