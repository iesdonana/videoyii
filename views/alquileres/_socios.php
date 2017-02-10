<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
?>

<?php Pjax::begin([
    'enablePushState' => false,
    ]) ?>

<?= \yii\grid\GridView::widget([
    'id' => 'sociosGrid',
    'dataProvider' => $dataProvider,
    'columns' => [
        'numero',
        'nombre',
        'direccion',
        'telefono',
    ],
    'tableOptions' => [
        'class' => 'table table-bordered table-hover',
    ],
]) ?>

<?php
$url = Url::to(['alquileres/gestionar']);
echo <<<EOT
    <script>
    $('#sociosGrid tr').click(function (event) {
        var target = event.currentTarget;
        if ($(target).children().length > 1) {
            var obj = $(target).children().first();
            numero = $(obj[0]).text();
            window.location.assign('$url' + '?numero=' + numero);
        }
    });
    </script>
EOT;
?>

<?php Pjax::end() ?>
