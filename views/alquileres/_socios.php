<?= \yii\grid\GridView::widget([
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
