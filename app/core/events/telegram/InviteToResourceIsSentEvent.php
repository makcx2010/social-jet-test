<?php

namespace core\events\telegram;

use core\events\BaseEvent;

class InviteToResourceIsSentEvent extends BaseEvent
{
    const DELAY = 30;

    public $chatId;
    public $messageId;

    public function __construct($chatId, $messageId)
    {
        $this->chatId = $chatId;
        $this->messageId = $messageId;
    }

    public function getDescription(): string
    {
        return 'Invite to resource is sent';
    }
}