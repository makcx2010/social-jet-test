<?php
return [
    'auth'     => \frontend\modules\auth\AuthModule::class,
    'user'     => \frontend\modules\user\UserModule::class,
    'client'   => \frontend\modules\client\ClientModule::class,
    'payment'  => \frontend\modules\payment\PaymentModule::class,
    'service'  => \frontend\modules\service\ServiceModule::class,
    'url'      => \frontend\modules\url\UrlModule::class,
    'log'      => \frontend\modules\log\LogModule::class,
    'gridview' => [
        'class'     => \kartik\grid\Module::class,
        'bsVersion' => '4'
    ],
];
