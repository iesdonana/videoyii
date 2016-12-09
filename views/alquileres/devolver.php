<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Alquiler */
/* @var $form ActiveForm */
?>
<div class="alquileres-devolver">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'numero') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

<?php if($alquileres !== null) {?>
<table class="table table-striped">
    <thead>
        <th>Código</th>
        <th>Título</th>
        <th>Alquilado</th>
        <th>Devolver</th>
    </thead>
    <tbody>
        <?php foreach ($alquileres as $k) { ?>

        <tr>
            <td><?= $k->pelicula->codigo ?></td>
            <td><?= $k->pelicula->titulo ?></td>
            <td><?= $k->alquilado ?></td>
            <td><?= Html::a('Delete', ['delete', 'id' => $k->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Quieres devolver la película?',
                    'method' => 'post',
                ],
            ]) ?></td>
        </tr><?php
    }?>
</tbody>
</table>
<?php
}?>
</div>
