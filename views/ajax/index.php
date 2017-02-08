<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$url = Url::to(['ajax/ajax'], true);
$js = <<<EOT
    $('#boton').click(function() {
        $.ajax({
            method: 'POST',
            url: '$url',
            success: function (data, status, event) {
                $('#contenido').append(data + '<br/>');
            }
        });
    });
EOT;
$this->registerJs($js);
?>
<h1>ajax/index</h1>

<?= Html::button('Púlsame', ['id' => 'boton']) ?>

<div id="contenido"></div>
