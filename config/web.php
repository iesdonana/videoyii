<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'formatter' => [
            'thousandSeparator' => ' ',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jMCaid1aETBL5zh4Ty0Q0hemNla8u4-V',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\components\User',
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'usuarios/view/<id:\d+>' => 'usuarios/view',
                'usuarios/update/<id:\d+>' => 'usuarios/update',
                'usuarios/<id:\d+>' => 'usuarios/view',
                'usuario/<id:\d+>' => 'usuarios/view',
                'usuarios/index/<sort>' => 'usuarios/index',
                'usuarios/index/<page:\d+>/<per-page:\d+>' => 'usuarios/index',
                'socio/<id:\d+>' => 'socios/view',
                'socios/update/<id:\d+>' => 'socios/update',
                'pelicula/view/<id:\d+>' => 'peliculas/view',
                'peliculas/update/<id:\d+>' => 'peliculas/update',
            ],
        ],
    ],
    'params' => $params,
    'language' => 'es_ES',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
