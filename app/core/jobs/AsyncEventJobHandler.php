<?php

namespace core\jobs;

use core\dispatchers\EventDispatcherInterface;
use yii\queue\Queue;

class AsyncEventJobHandler implements JobHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }


    public function handle($job, Queue $queue)
    {
        if (! $job instanceof AsyncEventJob) {
            throw new \InvalidArgumentException(get_class($job) . ' is not instance of AsyncEventJob');
        }
        $this->eventDispatcher->dispatch($job->event);
    }
}
