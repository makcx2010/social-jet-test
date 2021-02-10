<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', \common\bootstrap\SetUp::class, 'queue'],
    'controllerNamespace' => 'frontend\controllers',
    'modules'             => require __DIR__ . '/_modules.php',
    'layout'              => 'main',
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-frontend',
            'parsers'   => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'urlManager'   => function () {
            return \Yii::$app->get('frontendUrlManager');
        },
    ],
    'params'              => $params,
];
