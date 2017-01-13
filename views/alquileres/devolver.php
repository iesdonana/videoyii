<?php

use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DevolverForm */
/* @var $form ActiveForm */
?>
<div class="alquileres-devolver">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['devolver'],
    ]); ?>

        <?= $form->field($model, 'numero') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <?php if ($dataProvider !== null): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'pelicula.codigo',
                'pelicula.titulo',
                'alquilado:datetime',
                [
                    'class' => ActionColumn::className(),
                    'template' => '{delete}',
                    'urlCreator' => function ($action, $model, $key, $index, $column) {
                        $params = [
                            $action,
                            'id' => (string) $key,
                            'numero' => $model->socio->numero,
                        ];
                        return Url::toRoute($params);
                    }
                ],
            ],
        ]) ?>
    <?php endif ?>

</div><!-- alquileres-devolver -->
