<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$dbName = env('MYSQL_DATABASE');
$dbUser = env('MYSQL_USER');
$dbPassword = env('MYSQL_PASSWORD');
$dbHost = env('MYSQL_DOMAIN');

return [
    'aliases'    => [
        '@bower'        => '@vendor/bower-asset',
        '@npm'          => '@vendor/npm-asset',
        '@staticHost'   => $params['staticHostInfo'],
        '@frontendHost' => $params['frontendHostInfo']
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'   => 'ru',
    'timeZone'   => 'Europe/Moscow',
    'components' => [
        'cache'              => [
            'class'     => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],
        'db'                 => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'mysql:host=' . $dbHost . ';dbname=' . $dbName,
            'username' => $dbUser,
            'password' => $dbPassword,
            'charset'  => 'utf8',
        ],
        'redis'              => [
            'class'    => \yii\redis\Connection::class,
            'hostname' => env('REDIS_HOST', '127.0.0.1'),
            'port'     => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD', NULL),
            'retries'  => 3
        ],
        'queue'              => [
            'class'   => \yii\queue\redis\Queue::class,
            'as log'  => \yii\queue\LogBehavior::class,
            'redis'   => 'redis',
            'channel' => 'queue'
        ],
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'bot' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => env('BOT_TOKEN'),
        ],
        'botForChat' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => env('BOT_FOR_CHAT_TOKEN'),
        ]
    ]
];
