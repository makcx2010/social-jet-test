<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => \core\entities\User\User::class,
            'identityCookie' => new \yii\helpers\ReplaceArrayValue(['name' => '_identity', 'httpOnly' => true])
        ],
    ],
];
