<?php

namespace core\utilities\Telegram;

use aki\telegram\Telegram;
use core\dispatchers\AsyncEventDispatcher;
use core\events\telegram\UnblockUserEvent;
use GuzzleHttp\Client;
use yii\redis\Connection;

class BotForChatProcessor
{
    /** @var Telegram $telegram */
    private $telegram;
    /** @var Connection $redis */
    private $redis;
    private $asyncEventDispatcher;

    public function __construct
    (
        AsyncEventDispatcher $asyncEventDispatcher
    )
    {
        $this->telegram = \Yii::$app->botForChat;
        $this->redis = \Yii::$app->redis;
        $this->asyncEventDispatcher = $asyncEventDispatcher;
    }

    public function processChanges()
    {
        $lastUpdateId = $this->redis->get('last_update_for_chat_id');
        $updates = $this->telegram->getUpdates(['offset' => $lastUpdateId + 1]);

        if (!empty($updates['result'])) {
            foreach ($updates['result'] as $update) {
                $message = $update['message'];

                if (isset($message['new_chat_participant'])) {
                    $newUser = $message['new_chat_member'];

                    $this->blockUser($newUser['id'], $message['chat']['id']);
                }
            }
            if (isset($update)) {
                $this->redis->set('last_update_for_chat_id', $update['update_id']);
            }
        }
    }

    private function blockUser($id, $chatId)
    {
        $untilDate = time() + 180;
        $params = [
            'chat_id' => $chatId,
            'user_id' => $id,
            'permissions' => [
                'can_send_messages' => false,
            ],
            'until_date' => $untilDate,
        ];

        return $this->telegram->restrictChatMember($params);
    }
}