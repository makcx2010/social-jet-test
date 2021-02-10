<?php

namespace core\jobs;

use yii\queue\Queue;

interface JobHandler
{
    public function handle($job, Queue $queue);
}
