<?php

use yii\db\Migration;

/**
 * Handles the creation of table `url_mapping`.
 */
class m210209_082231_create_url_mapping_table extends Migration
{
    private $table = 'url_mapping';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id'         => $this->primaryKey(),
                'token'      => $this->string()->unique(),
                'long_url'   => $this->string(),
                'created_at' => $this->dateTime()->defaultExpression('NOW()')
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
