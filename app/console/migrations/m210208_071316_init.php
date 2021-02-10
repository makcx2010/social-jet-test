<?php

use yii\db\Migration;

/**
 * Class m210208_071316_init
 */
class m210208_071316_init extends Migration
{
    private $roles = 'roles';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            'users',
            [
                'id'          => $this->primaryKey(),
                'role'     => $this->string(),
                'telegram_id' => $this->integer()->notNull()->unique(),
                'username'    => $this->string(),
                'first_name'  => $this->string(),
                'last_name'   => $this->string(),
                'created_at'  => $this->dateTime()->defaultExpression('NOW()')
            ],
            $tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
