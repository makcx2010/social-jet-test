<?php

namespace core\jobs;

abstract class Job extends \yii\queue\closure\Job
{
    public function execute($queue)
    {
        $listener = $this->resolveHandler();
        $listener($this, $queue);
    }

    private function resolveHandler()
    {
        $handler = \Yii::createObject(static::class . "Handler");
        if (! $handler instanceof JobHandler) {
            throw new \DomainException('Job handler ' . static::class . 'Handler' . ' is not exist or is not instance of JobHandler interface');
        }

        return [$handler, 'handle'];
    }
}
