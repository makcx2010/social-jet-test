<?php

namespace common\bootstrap;

use yii\base\BootstrapInterface;
use yii\queue\Queue;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(Queue::class, function () use ($app) {
            return $app->get('queue');
        });;
    }
}
