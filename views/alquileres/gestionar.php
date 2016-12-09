<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\GestionarForm */
/* @var $form ActiveForm */
?>
<div class="alquileres-gestionar">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar'],
    ]); ?>

        <?= $form->field($devolver, 'numero') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <?php if ($dataProvider !== null) {
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'pelicula.codigo',
                'pelicula.titulo',
                'alquilado',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                ],
            ],
        ]);
    } ?>


</div><!-- alquileres-devolver -->

<div class="alquileres-gestionar">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($alquiler, 'codigo') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- alquileres-alquilar -->
