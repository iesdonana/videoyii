<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="alquiler-total">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['total'],
    ]) ?>
        <?= $form->field($model, 'fecha')->dropDownList($fechas) ?>
        <div class="form-group">
            <?= Html::submitButton('Calcular total', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end() ?>
    <?php if ($total !== null) { ?>
        <h2>El total es <?= Yii::$app->formatter->asCurrency($total) ?></h2>
    <?php } ?>
</div>
