<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\GestionarForm */
/* @var $form ActiveForm */
$this->title = 'Gestionar';
?>
<div class="alquileres-gestionar">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar'],
    ]); ?>

        <?= $form->field($devolver, 'numero') ?>

        <div class="form-group">
            <?= Html::submitButton('Mostrar', ['class' => 'btn btn-primary']) ?>
            <?= Html::encode($socio !== null ? 'Socio: ' . $socio->nombre : '') ?>
        </div>
    <?php ActiveForm::end(); ?>

    <?php if ($dataProvider !== null) {
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'pelicula.codigo',
                'pelicula.titulo',
                [
                    'attribute' => 'alquilado',
                    'format' => ['dateTime'],
                ],
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
            <?= Html::submitButton('Alquilar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- alquileres-alquilar -->
