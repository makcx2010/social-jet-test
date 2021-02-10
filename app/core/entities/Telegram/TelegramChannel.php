<?php

namespace core\entities\Telegram;

use core\entities\BaseEntity;

/**
 * Class Transaction
 *
 * @package core\entities\Url
 * @property integer $id
 * @property string  $name
 * @property string  $invite_url
 */

class TelegramChannel extends BaseEntity
{
    public static function tableName()
    {
        return 'telegram_channels';
    }

    public static function create($name, $inviteUrl): self
    {
        $telegramChannel = new self();
        $telegramChannel->name = $name;
        $telegramChannel->invite_url = $inviteUrl;

        return $telegramChannel;
    }
}