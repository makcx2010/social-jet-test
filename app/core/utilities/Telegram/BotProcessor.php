<?php

namespace core\utilities\Telegram;

use aki\telegram\base\Response;
use aki\telegram\Telegram;
use aki\telegram\types\Result;
use core\dispatchers\AsyncEventDispatcher;
use core\entities\Telegram\TelegramChannel;
use core\entities\Url\UrlMapping;
use core\entities\User\User;
use core\events\telegram\InviteToResourceIsSentEvent;
use core\repositories\Telegram\TelegramChannelRepository;
use core\repositories\Url\UrlMappingRepository;
use core\repositories\User\UserRepository;
use yii\redis\Connection;
use yii\web\UrlManager;

class BotProcessor
{
    const SALT_MESSAGES_ID = 'chat_messages_';

    /** @var Telegram $telegram */
    private $telegram;
    /** @var Connection $redis */
    private $redis;
    private $userRepository;
    private $telegramChannelRepository;
    private $urlMappingRepository;
    private $asyncEventDispatcher;

    public function __construct
    (
        UserRepository $userRepository,
        TelegramChannelRepository $telegramChannelRepository,
        UrlMappingRepository $urlMappingRepository,
        AsyncEventDispatcher $asyncEventDispatcher
    )
    {
        $this->telegram = \Yii::$app->bot;
        $this->redis = \Yii::$app->redis;
        $this->userRepository = $userRepository;
        $this->telegramChannelRepository = $telegramChannelRepository;
        $this->urlMappingRepository = $urlMappingRepository;
        $this->asyncEventDispatcher = $asyncEventDispatcher;
    }

    public function processChanges()
    {
        $lastUpdateId = $this->redis->get('last_update_id');
        $updates = $this->telegram->getUpdates(['offset' => $lastUpdateId + 1]);

        if (!empty($updates['result'])) {
            foreach ($updates['result'] as $update) {
                $prevMessageIds = [];

                if (isset($update['message'])) {
                    $message = $update['message'];
                    $redisKey = self::SALT_MESSAGES_ID . $message['chat']['id'];

                    while (!empty($messageId = $this->redis->lpop($redisKey))) {
                        $prevMessageIds[] = $messageId;
                    }

                    $this->deleteMessages($message['chat']['id'], $prevMessageIds);
                    $response = $this->processMessage($message);

                    $this->redis->rpush($redisKey, $message['message_id'], $response->getResult()->message_id);
                } elseif (isset($update['callback_query'])) {
                    $callbackQuery = $update['callback_query'];
                    $message = $callbackQuery['message'];
                    $redisKey = self::SALT_MESSAGES_ID . $message['chat']['id'];

                    while (!empty($messageId = $this->redis->lpop($redisKey))) {
                        $prevMessageIds[] = $messageId;
                    }

                    $this->deleteMessages($message['chat']['id'], $prevMessageIds);
                    $response = $this->processCallbackQuery($callbackQuery);
                    /** @var Result $result */
                    $result = $response->getResult();


                    $this->asyncEventDispatcher->dispatch(new InviteToResourceIsSentEvent($result->getChat()->id, $result->message_id), InviteToResourceIsSentEvent::DELAY);
                    $this->redis->rpush($redisKey, $result->message_id);
                }
            }
            if (isset($update)) {
                $this->redis->set('last_update_id', $update['update_id']);
            }
        }
    }

    private function processMessage($message): Response
    {
        $from = $message['from'];
        $user = $this->userRepository->getByTelegramId($from['id']);

        if (!$user) {
            $user = User::create($from['id'], $from['first_name'], $from['last_name']);
            $this->userRepository->save($user);
        }
        if ($user->isAdmin()) {
            if (strpos($message['text'], '/add') === 0) {
                $response = $this->createResource($message);
            } elseif (strpos($message['text'], '/resources') === 0) {
                $response = $this->sendResources($message);
            } elseif (strpos($message['text'], '/delete') === 0) {
                $response = $this->deleteResource($message);
            } else {
                $response = $this->sendAdminMessage($message);
            }
        } else {
            $response = $this->sendResourcesToUser($message);
        }

        return $response;
    }

    private function createResource($message): Response
    {
        [$command, $resourceName, $resourceLink] = explode(' ', $message['text']);

        $telegramChannel = TelegramChannel::create($resourceName, $resourceLink);
        $params = [
            'chat_id' => $message['chat']['id'],
            'text'    => 'Успех!',
        ];

        $this->telegramChannelRepository->save($telegramChannel);

        return $this->sendMessage($params);
    }

    private function sendResources($message): Response
    {
        /** @var TelegramChannel[] $telegramChannels */
        $telegramChannels = $this->telegramChannelRepository->getAll();
        $params = [
            'chat_id' => $message['chat']['id'],
            'text'    => '',
        ];

        if (!empty($telegramChannels)) {
            foreach ($telegramChannels as $telegramChannel) {
                $params['text'] .= 'id - ' . $telegramChannel->id . ', name - ' . $telegramChannel->name . "\r\n";
            }
        } else {
            $params['text'] = 'Не найдено.';
        }

        return $this->sendMessage($params);
    }

    private function deleteResource($message): Response
    {
        [$command, $id] = explode(' ', $message['text']);
        /** @var TelegramChannel[] $telegramChannels */
        $telegramChannel = $this->telegramChannelRepository->get($id);
        $this->telegramChannelRepository->remove($telegramChannel);

        $params = [
            'chat_id' => $message['chat']['id'],
            'text'    => 'Ресурс был удален.',
        ];

        return $this->sendMessage($params);
    }

    private function sendAdminMessage(array $message): Response
    {
        $params = [
            'chat_id'      => $message['chat']['id'],
            'text'         => 'TEST',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => 'Привет админ.', 'url' => 'http://telegram.bot.local', 'callback_data' => 'this is me']
                    ]
                ]
            ])
        ];

        return $this->sendMessage($params);
    }

    private function sendResourcesToUser(array $message): Response
    {
        $buttons = [];
        /** @var TelegramChannel[] $resources */
        $resources = $this->telegramChannelRepository->getAll();
        foreach ($resources as $resource) {
            $buttons[] = ['text' => $resource->name, 'callback_data' => $resource->id];
        }
        $params = [
            'chat_id'      => $message['chat']['id'],
            'text'         => 'Выберите ресурс.',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    $buttons
                ]
            ])
        ];
        return $this->sendMessage($params);
    }

    private function sendMessage($params): Response
    {
        return $this->telegram->sendMessage($params);
    }

    private function deleteMessages($chatId, array $deleteMessages): void
    {
        foreach ($deleteMessages as $messageId) {
            if ($messageId) {
                $this->telegram->deleteMessage(['chat_id' => $chatId, 'message_id' => $messageId]);
            }
        }
    }

    private function processCallbackQuery($callbackQuery): Response {
        /** @var TelegramChannel $telegramChannel */
        $telegramChannel = $this->telegramChannelRepository->get($callbackQuery['data']);

        $urlToken = \Yii::$app->getSecurity()->generateRandomString(UrlMapping::DEFAULT_TOKEN_LENGTH);
        $urlMapping = UrlMapping::create($urlToken, $telegramChannel->invite_url);
        /** @var UrlManager $frontendUrlManager */
        $frontendUrlManager = \Yii::$app->get('frontendUrlManager');
        $params = [
            'chat_id'      => $callbackQuery['message']['chat']['id'],
            'text'         => 'Приглашение',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => 'Кнопка для перехода', 'url' => $frontendUrlManager->createAbsoluteUrl($urlToken)]
                    ]
                ]
            ])
        ];

        $this->urlMappingRepository->save($urlMapping);
        return $this->sendMessage($params);
    }
}