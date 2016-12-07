<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlquilerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alquilers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alquiler-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Alquiler', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'socio_id',
            'pelicula_id',
            'precio_alq',
            'alquilado',
            // 'devuelto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
