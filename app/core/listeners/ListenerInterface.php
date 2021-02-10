<?php

namespace core\listeners;

use core\events\BaseEvent;

interface ListenerInterface
{
    public function handle(BaseEvent $event):void;
}
