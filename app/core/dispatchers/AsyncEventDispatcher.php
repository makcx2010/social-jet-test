<?php

namespace core\dispatchers;

use core\jobs\AsyncEventJob;
use yii\queue\Queue;

class AsyncEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var Queue
     */
    private $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    public function dispatch($event, $delay = null): void
    {
        if ($delay) {
            $this->queue->delay($delay);
        }
        $this->queue->push(new AsyncEventJob($event));
    }
}
