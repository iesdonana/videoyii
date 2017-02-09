<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */
/* @var $alquileres Alquiler[] */

$this->title = 'Alquileres';
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['ajax']);
$urlActual = Url::to(['']);
$js = <<<EOT
    $('#numero').keyup(function() {
        var q = $('#numero').val();
        if (q == '') {
            $('#socios').html('');
        }
        if (!isNaN(q)) {
            return;
        }
        $.ajax({
            method: 'GET',
            url: '$url',
            data: {
                nombre: q
            },
            success: function (data, status, event) {
                $('#socios').html(data);
                $('#socios tr').click(function (event) {
                    var target = event.currentTarget;
                    if ($(target).children().length > 1) {
                        var obj = $(target).children().first();
                        numero = $(obj[0]).text();
                        window.location.assign('$urlActual' + '?numero=' + numero);
                    }
                });
            }
        });
    });
EOT;
$this->registerJs($js);
?>
<div class="alquileres-gestionar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar'],
    ]); ?>
        <?= $form->field($model, 'numero') ?>
        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- alquileres-alquilar -->


<div id="socios">

</div>


<?php if (!empty($alquileres)) {
        ?>
    <table class="table table-striped">
        <thead>
            <th>Código</th>
            <th>Título</th>
            <th>Alquiler</th>
            <th>Devolver</th>
        </thead>
        <tbody>
            <?php foreach ($alquileres as $alquiler) {
            ?>
                <tr <?= $alquiler->estaAtrasado ? 'style="color:red"' : '' ?>>
                    <td><?= Html::encode($alquiler->pelicula->codigo) ?></td>
                    <td><?= Html::encode($alquiler->pelicula->titulo) ?></td>
                    <td><?= Html::encode(Yii::$app->formatter->asDatetime($alquiler->alquilado)) ?></td>
                    <td>
                        <?= Html::a('Devolver', [
                            'alquileres/delete',
                            'id' => $alquiler->id,
                            'numero' => $model->numero,
                        ], [
                            'class' => 'btn btn-xs btn-danger',
                            'data' => [
                                'confirm' => '¿Desea devolver esta película?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php

        } ?>
        </tbody>
    </table>
<?php

    } ?>
<?php if ($model->esValido) {
        ?>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model2, 'codigo') ?>
        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<?php

    } ?>
