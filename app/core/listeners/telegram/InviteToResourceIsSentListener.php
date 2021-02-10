<?php

namespace core\listeners\telegram;

use aki\telegram\Telegram;
use core\events\BaseEvent;
use core\events\telegram\InviteToResourceIsSentEvent;
use core\listeners\ListenerInterface;

class InviteToResourceIsSentListener implements ListenerInterface
{
    /** @var Telegram $telegram */
    private $telegram;

    public function __construct() {
        $this->telegram = \Yii::$app->bot;
    }

    public function handle(BaseEvent $event): void
    {
        if (!$event instanceof InviteToResourceIsSentEvent) {
            throw new \InvalidArgumentException('Event instance is not equal to InviteToResourceIsSentEvent');
        }

        $params = [
            'chat_id'      => $event->chatId,
            'message_id'      => $event->messageId,
            'text'         => 'Сообщение устарело. Запросите новое.'
        ];
        $this->telegram->editMessageText($params);
    }
}