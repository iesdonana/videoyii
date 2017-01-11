<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DevolverForm */
/* @var $form ActiveForm */

$this->title = 'Alquileres';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alquileres-gestionar">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar'],
    ]); ?>

        <?= $form->field($devolver, 'numero') ?>

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
                [
                    'attribute' => 'alquilado',
                    'format' => ['dateTime',],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                ],
            ],
        ]) ?>
    <?php

    } ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($alquilar, 'codigo') ?>
    <div class="form-group">
        <?= Html::submitButton('Alquilar', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div><!-- alquileres-gestionar -->
