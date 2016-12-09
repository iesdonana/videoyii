<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DevolverForm */
/* @var $form ActiveForm */
?>
<div class="alquileres-devolver">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'numero') ?>

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
        ]) ?>
    <?php

} ?>

</div><!-- alquileres-devolver -->
