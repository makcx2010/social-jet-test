<?php

namespace core\repositories\Telegram;

use core\entities\Telegram\TelegramChannel;
use core\repositories\BaseRepository;

class TelegramChannelRepository extends BaseRepository
{
    public function getAll(): array
    {
        return TelegramChannel::find()->all();
    }

    protected function getEntityClass(): string
    {
        return TelegramChannel::class;
    }

    protected function getEntityLabel()
    {
        return 'Telegram channel';
    }
}