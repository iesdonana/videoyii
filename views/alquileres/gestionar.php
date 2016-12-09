<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DevolverForm */
/* @var $form ActiveForm */
?>
<div class="alquileres-gestionar">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'numero') ?>

        <div class="form-group">
            <?= Html::submitButton('Buscar alquileres', ['class' => 'btn btn-primary']) ?>
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

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'codigo') ?>
    <div class="form-group">
        <?= Html::submitButton('Alquilar', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div><!-- alquileres-gestionar -->
