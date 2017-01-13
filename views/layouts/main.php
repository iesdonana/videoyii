<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Alert;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Videoclub Los Pajaritos',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $items = [
        ['label' => 'Socios', 'url' => ['socios/index']],
        ['label' => 'Películas', 'url' => ['peliculas/index']],
        ['label' => 'Alquileres', 'url' => ['alquileres/gestionar']],
        Yii::$app->user->isGuest ?
            ['label' => 'Regístrate o inicia sesión', 'url' => ['#'], 'items' => [
                            ['label' => 'Regístrate', 'url' => ['usuarios/create']],
                            ['label' => 'Iniciar sesión', 'url' => ['site/login']],
            ]]
          : ['label' => Yii::$app->user->identity->nombre, 'url' => ['usuarios/index'], 'items' =>
                [
                    ['label' => 'Ver perfil', 'url' => ['usuarios/view', 'id' => Yii::$app->user->identity->id]],
                    ['label' => 'Editar perfil', 'url' => ['usuarios/update', 'id' => Yii::$app->user->identity->id]],
                    '<li class="divider"></li>',
                    (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Cerrar sesión',
                        ['class' => 'btn-sm btn-danger center-block']
                    )
                    . Html::endForm()
                    . '</li>'
                    )
                ]
            ],

    ];
    if (Yii::$app->user->esAdmin) {
        array_unshift($items, ['label' => 'Usuarios', ['usuarios/create']]);
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php if (Yii::$app->session->hasFlash('exito')) {
            echo Alert::widget([
                'options' => [
                    'class' => 'alert-success',
                ],
                'body' => Yii::$app->session->getFlash('exito'),
            ]);
        } ?>
        <?php if (Yii::$app->session->hasFlash('fracaso')) {
            echo Alert::widget([
                'options' => [
                    'class' => 'alert-danger',
                ],
                'body' => Yii::$app->session->getFlash('fracaso'),
            ]);
        } ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; IES Doñana <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
