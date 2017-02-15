<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\models\Socio;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */
/* @var $alquileres Alquiler[] */

$this->title = 'Alquileres';
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['ajax']);
$urlActual = Url::to(['alquileres/gestionar']);
$js = <<<EOT
    $('#numero').keyup(function() {
        var q = $('#numero').val();
        if (q == '') {
            $('#socios').html('');
            $('.oculto').html('');
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
            }
        });
    });
EOT;
$this->registerJs($js);

$nombre = empty($model->numero) ? '' : Socio::findOne(['numero' => $model->numero])->nombre;
?>
<div class="alquileres-gestionar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar'],
    ]); ?>
        <?= $form->field($model, 'numero')->widget(Select2::classname(), [
            'initValueText' => $nombre, // set the initial display text
            'options' => ['placeholder' => 'Selecciona un usuario ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 2,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(socio) { return socio.text; }'),
                'templateSelection' => new JsExpression('function (socio) { return socio.text; }'),
            ],
        ]); ?>
        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- alquileres-alquilar -->


<div id="socios">

</div>


<?php if (!empty($alquileres)) {
        ?>
    <table class="table table-striped oculto">
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
    <?php $form = ActiveForm::begin(['options' => ['class' => 'oculto']]); ?>
        <?= $form->field($model2, 'codigo') ?>
        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<?php

    } ?>
