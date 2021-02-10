<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$dbName     = env('MYSQL_DATABASE');
$dbUser     = env('MYSQL_ADMIN_USER');
$dbPassword = env('MYSQL_ADMIN_PASSWORD');
$dbHost     = env('MYSQL_DOMAIN');

return [
    'id'                  => 'app-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', \common\bootstrap\SetUp::class, \console\bootstrap\SetUp::class, 'queue'],
    'controllerNamespace' => 'console\controllers',
    'aliases'             => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap'       => [
        'fixture' => [
            'class'     => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
    ],
    'components'          => [
        'db'          => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'mysql:host=' . $dbHost . ';dbname=' . $dbName,
            'username' => $dbUser,
            'password' => $dbPassword,
            'charset'  => 'utf8',
        ],
        'log'         => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ]
    ],
    'modules'             => require __DIR__ . '/_modules.php',
    'params'              => $params,
];
