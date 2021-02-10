<?php
$dbHost = env('MYSQL_DOMAIN');

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=' . $dbHost . ';dbname=edgvr2_test',
        ]
    ],
];
