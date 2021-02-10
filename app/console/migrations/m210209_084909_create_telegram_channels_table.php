<?php

use yii\db\Migration;

/**
 * Handles the creation of table `telegram_channels`.
 */
class m210209_084909_create_telegram_channels_table extends Migration
{
    private $table = 'telegram_channels';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id'         => $this->primaryKey(),
                'name'       => $this->string(),
                'invite_url' => $this->string()
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
