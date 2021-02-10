<?php

namespace console\controllers;

use core\dispatchers\AsyncEventDispatcher;
use core\events\telegram\ActivateBotEvent;
use core\utilities\Telegram\BotForChatProcessor;
use core\utilities\Telegram\BotProcessor;
use yii\console\Controller;
use yii\redis\Connection;

class TelegramController extends Controller
{
    const IS_BOT_ACTIVATED = 'infiniteCycle';
    const IS_BOT_FOR_CHAT_ACTIVATED = 'chatBotInfiniteCycle';

    /** @var Connection */
    private $redis;
    private $botProcessor;
    private $botForChatProcessor;
    private $asyncEventDispatcher;

    public function __construct
    (
        $id,
        $module,
        BotProcessor $botProcessor,
        BotForChatProcessor $botForChatProcessor,
        AsyncEventDispatcher $asyncEventDispatcher,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->redis = \Yii::$app->redis;
        $this->botProcessor = $botProcessor;
        $this->botForChatProcessor = $botForChatProcessor;
        $this->asyncEventDispatcher = $asyncEventDispatcher;
    }

    public function actionActivateBot() {
        $this->stdout("Success\r\n");
        $this->redis->set(self::IS_BOT_ACTIVATED, true);

        while($this->redis->get(TelegramController::IS_BOT_ACTIVATED)) {
            try {
                $this->botProcessor->processChanges();
            } catch (\Exception $e) {
                $this->stdout($e->getMessage() . "\r\n");
                exit();
            }

            sleep(1);
        }
    }

    public function actionDeactivateBot() {
        $this->redis->set(self::IS_BOT_ACTIVATED, false);

        return $this->stdout("Bot is off\r\n");
    }

    public function actionActivateBotForChat() {
        $this->stdout("Success\r\n");
        $this->redis->set(self::IS_BOT_FOR_CHAT_ACTIVATED, true);

        while($this->redis->get(TelegramController::IS_BOT_FOR_CHAT_ACTIVATED)) {
            try {
                $this->botForChatProcessor->processChanges();
            } catch (\Exception $e) {
                $this->stdout($e->getMessage() . "\r\n");
                exit();
            }

            sleep(1);
        }
    }

    public function actionDeactivateBotForChat() {
        $this->redis->set(self::IS_BOT_FOR_CHAT_ACTIVATED, false);

        return $this->stdout("Bot is off\r\n");
    }
}