<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$url = Url::to(['ajax/ajax']);
$js = <<<EOT
    $('#provincia').change(function() {
        $.ajax({
            method: 'POST',
            url: '$url',
            data: {
                id: $('#provincia option:selected').val()
            },
            success: function (data, status, event) {
                var d = JSON.parse(data);
                while ($('#localidades').children().length > 1) {
                    $('#localidades').children().last().remove();
                }
                for (l in d) {
                    $('#localidades').append('<option value="' + l + '">' + d[l] + '</option>');
                }
            }
        });
    });
EOT;
$this->registerJs($js);
?>
<h1>ajax/index</h1>

<?= Html::dropDownList('provincia', null, [
        '1' => 'Cádiz',
        '2' => 'Sevilla',
        '3' => 'Huelva',
    ], ['id' => 'provincia', 'prompt' => 'Provincia...']) ?>

<?= Html::dropDownList('localidades', null, [], [
    'id' => 'localidades', 'prompt' => 'Localidades...']) ?>
