<?php

use app\models\Socio;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\AlquilerForm */
/* @var $form ActiveForm */
/* @var $alquileres Alquiler[] */

$this->title = 'Alquileres';
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to(['alquileres/socios']);
$urlActual = Url::to(['alquileres/gestionar']);
$js = <<<EOT
    var delay = (function() {
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
    $('#numero').keyup(function() {
        delay(function() {
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
                    q: q
                },
                success: function (data, status, event) {
                    $('#socios').html(data);
                }
            });
        }, 500);
    });
EOT;
$this->registerJs($js);

$nombre = empty($model->numero) ? '' :
          Socio::findOne(['numero' => $model->numero])->nombre;
?>
<div class="alquileres-gestionar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['alquileres/gestionar'],
    ]); ?>
        <?= $form->field($model, 'numero')->widget(Select2::classname(), [
            'initValueText' => $nombre,
            'language' => 'es',
            'options' => ['placeholder' => 'Buscar socio...'],
            // 'data' => Socio::find()
            //     ->select('numero as id, nombre as text')
            //     ->asArray()
            //     ->all(),
            'pluginOptions' => [
                'allowClear' => true,
                // 'minimumInputLength' => 2,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Esperando resultados...'; }"),
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
