<?php

namespace core\events;

abstract class BaseEvent
{
    public $logEvent    = true;
    public $description = null;

    abstract public function getDescription(): string;

    public function setDescription($description): void
    {
        $this->description = $description;
    }
}
