<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Pelicula;

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

    <?php if ($alquileres !== null && $socio !== null) {
    ?>
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading"><?= $socio->id ?> - <?= $socio->nombre ?></div>

    <table class="table table-striped">
      <thead>
          <th>Nº Película</th>
          <th>Título</th>
          <th>Fecha Alquiler</th>
          <th>Acción</th>
      </thead>
      <tbody><?php
        foreach ($alquileres as $fila) {
            ?>
            <tr>
              <td><?= Html::encode($fila['pelicula']->codigo) ?></td>
              <td><?= Html::encode($fila['pelicula']->titulo) ?></td>
              <td><?= Html::encode($fila['alquilado']) ?></td>
              <td>
                  <?= Html::a('Delete', ['delete', 'id' => $fila->id], [
                      'class' => 'btn btn-danger btn-xs',
                      'data' => [
                          'confirm' => '¿Desea devolver la película?',
                          'method' => 'post',
                      ],
                  ]) ?>
              </td>
            </tr><?php

        } ?>
      </tbody>
    </table>
    <?php

} ?>
</div><!-- alquileres-devolver -->
